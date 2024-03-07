<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\Item;
use App\Models\History;
use App\Models\OrderImport;
// その他
use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Rap2hpoutre\FastExcel\FastExcel;

class OrderController extends Controller
{
    public function index()
    {
        // 発注インポートデータを取得
        $order_imports = OrderImport::getAll()->get();
        return view('order.index')->with([
            'order_imports' => $order_imports,
        ]);
    }

    public function upload(Request $request)
    {   
        // 追加先のテーブルをクリア
        OrderImport::query()->delete();
        try {
            $result = DB::transaction(function () use ($request) {
                // 現在の日時を取得
                $nowDate = CarbonImmutable::now();
                // 拡張子がCSVであるかの確認
                if ($request->csvFile->getClientOriginalExtension() !== "xlsx") {
                    throw new \Exception('拡張子がxlsxではありません。');
                }
                // ストレージに保存する際のファイル名を指定(customer_import_ユーザーID_現在日時.csv)
                $store_file_name = 'order_import_'.$nowDate->isoFormat('YMMDDHHmmss').'.xlsx';
                // 選択したファイルのファイル名を取得
                $uploaded_file = $request->file('csvFile')->getClientOriginalName();
                // ストレージにファイルを保存して、パスを返す
                $path = $request->file('csvFile')->storeAs('public/import', $store_file_name);
                // 保存したCSVファイルのデータを取得
                $data = (new FastExcel)->import(storage_path('app/' . $path));
                // テーブルにデータを追加
                foreach($data as $item){
                    // 数量が1以上のものだけ追加する
                    if($item['数量'] > 0){
                        OrderImport::create([
                            'item_code' => $item['商品コード'],
                            'quantity' => $item['数量'],
                            'order_file_name' => $uploaded_file,
                        ]);
                    }
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
            'alert_message' => '発注ファイルをアップロードしました。',
        ]);
    }

    public function confirm(Request $request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                // 現在の日時を取得
                $nowDate = CarbonImmutable::now();
                // 発注インポートテーブルと商品マスタの差分を商品コードで取得
                $diff = OrderImport::whereNotIn('item_code', Item::pluck('item_code'))->get();
                // 差分があれば処理を中断
                if (count($diff) > 0) {
                    throw new \Exception('商品マスタに存在しない商品が存在する為、中断しました。');
                }
                // 履歴テーブルに追加
                foreach(OrderImport::all() as $order_import){
                    History::create([
                        'date' => $nowDate->format('Y-m-d'),
                        'time' => $nowDate->format('H:i:s'),
                        'category' => '発注',
                        'item_code' => $order_import->item_code,
                        'quantity' => $order_import->quantity,
                        'comment' => $order_import->order_file_name
                    ]);
                }
                // テーブルをクリア
                OrderImport::query()->delete();
            });
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'alert_type' => 'error',
                'alert_message' => $e->getMessage(),
            ]);
        }
        return redirect()->route('history.index')->with([
            'alert_type' => 'success',
            'alert_message' => '発注を確定しました。',
        ]);
    }
}
