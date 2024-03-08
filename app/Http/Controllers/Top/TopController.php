<?php

namespace App\Http\Controllers\Top;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\Item;
use App\Models\History;
use App\Models\ItemImport;
// その他
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\File;

class TopController extends Controller
{
    public function index()
    {
        $items = $this->getItems()->get();
        return view('top')->with([
            'items' => $items,
        ]);
    }

    public function getItems()
    {
        // 発注数の合計を取得
        $total_order_quantity = History::where('category', '発注')
                                ->select(DB::raw("sum(quantity) as total_order_quantity, item_code"))
                                ->groupBy('item_code');
        // 発注数の合計と商品マスタを結合
        $items = Item::leftJoinSub($total_order_quantity, 'SUB', function ($join) {
                        $join->on('items.item_code', '=', 'SUB.item_code');
                    })
                    ->select('items.*', DB::raw("COALESCE(total_order_quantity, 0) as total_order_quantity"))
                    ->orderBy('item_code', 'asc');
        return $items;
    }

    public function download()
    {
        // ダウンロードするデータを取得
        $response = new StreamedResponse(function (){
            // ハンドルを取得
            $handle = fopen('php://output', 'wb');
            // BOMを書き込む
            fwrite($handle, "\xEF\xBB\xBF");
            // システムに定義してあるヘッダーを取得し、書き込む
            $header = Item::csvHeader();
            fputcsv($handle, $header);
            // 商品を取得
            $items = $this->getItems();
            // レコードをチャンクごとに書き込む
            $items->chunk(500, function ($items) use ($handle) {
                // 履歴の分だけループ
                foreach($items as $item){
                    // 初回パッケージ数量 - 発注数の合計
                    $first_package_remaining = $item->first_package_quantity - $item->total_order_quantity;
                    // マイナスであれば、0に変換
                    if($first_package_remaining < 0){
                        $first_package_remaining = 0;
                    }
                    $row = [
                        $item->item_code,
                        $item->jan_code,
                        $item->item_name_1,
                        $item->item_name_2,
                        $item->first_package_quantity,
                        $item->total_order_quantity,
                        $first_package_remaining,
                    ];
                    fputcsv($handle, $row);
                };
            });
            // ファイルを閉じる
            fclose($handle);
        });
        // ダウンロード処理
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=【スターデザイン管理システム】商品マスタ_' . CarbonImmutable::now()->isoFormat('Y年MM月DD日HH時mm分ss秒') . '.csv');
        return $response;
    }

    public function upload(Request $request)
    {
        // 追加先のテーブルをクリア
        ItemImport::query()->delete();
        try {
            $result = DB::transaction(function () use ($request) {
                // 拡張子がCSVであるかの確認
                // 現在の日時を取得
                $nowDate = CarbonImmutable::now();
                if ($request->csvFile->getClientOriginalExtension() !== "csv") {
                    throw new \Exception('拡張子がcsvではありません。');
                }
                // ストレージに保存する際のファイル名を指定
                $store_file_name = 'item_import_'.$nowDate->isoFormat('YMMDDHHmmss').'.csv';
                // 選択したファイルのファイル名を取得
                $uploaded_file = $request->file('csvFile')->getClientOriginalName();
                // ストレージにファイルを保存して、パスを返す
                $path = $request->file('csvFile')->storeAs('public/import', $store_file_name);
                // 保存したCSVファイルのデータを取得
                $csv = File::get(storage_path('app/' . $path));
                // 文字コードをUTF-8に変換
                $csv = mb_convert_encoding($csv, 'UTF-8', 'ASCII, JIS, UTF-8, SJIS-win');
                // BOMを削除する
                $csv = str_replace("\u{FEFF}", "", $csv);
                // 改行コードに「CRLF」又は「CR」が存在している場合
                if (strpos($csv, "\r") !== false) {
                    // 「LF」との混在の可能性があるので、「LF」を削除する
                    $csv = str_replace("\n", "", $csv);
                    // 改行コードを「LF」に統一するので、「CRLF」と「CR」を「LF」に置換する
                    $csv = str_replace(array("\r\n", "\r"), "\n", $csv);
                }
                // $csvを元に行単位のコレクションを作成し、改行コードだけの要素を削除
                $csv_records = collect(explode("\n", $csv))->filter(function ($item) {
                    return !empty(trim($item));
                });
                // システムに定義してあるヘッダーを取得
                $header = Item::csvHeader();
                // CSVからヘッダーを取得(shiftメソッドにより、最初の要素が取り除かれるので、ヘッダーがコレクションから無くなる)
                $csvHeader = explode(",", $csv_records->shift());
                // ヘッダーを比較し、差分があればエラー情報を返す
                if (!empty(array_diff_assoc($header, $csvHeader))) {
                    return 'ヘッダーに相違がある為、インポートできませんでした。';
                }
                // ヘッダーをコレクションに変換
                $header = collect(ItemImport::csvHeader_EN());
                // ヘッダーをキーにした連想配列のコレクションを作成
                $items = $csv_records->map(fn($oneRecord) => $header->combine(collect(str_getcsv($oneRecord))));
                // テーブルにデータを追加
                foreach($items as $item){
                    ItemImport::create([
                        'item_code' => $item['item_code'],
                        'jan_code' => $item['jan_code'],
                        'item_name_1' => $item['item_name_1'],
                        'item_name_2' => $item['item_name_2'],
                        'first_package_quantity' => $item['first_package_quantity'],
                        'total_order_quantity' => $item['total_order_quantity'],
                        'first_package_remaining' => $item['first_package_remaining'],
                    ]);
                }
                /// 商品インポートテーブルと商品マスタの差分を取得
                $diff = ItemImport::whereNotIn('item_code', Item::pluck('item_code'))->select('*')->get();
                // 差分を追加
                foreach($diff as $item){
                    Item::create([
                        'item_code' => $item->item_code,
                        'jan_code' => $item->jan_code,
                        'item_name_1' => $item->item_name_1,
                        'item_name_2' => $item->item_name_2,
                        'first_package_quantity' => $item->first_package_quantity,
                    ]);
                }
                // アップロードしたファイルを削除
                unlink(storage_path('app/' . $path));
            });
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'alert_type' => 'error',
                'alert_message' => $e->getMessage(),
            ]);
        }
        return redirect()->back()->with([
            'alert_type' => 'success',
            'alert_message' => '商品データをアップロードしました。',
        ]);
    }
}
