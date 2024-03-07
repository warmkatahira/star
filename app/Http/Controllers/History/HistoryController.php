<?php

namespace App\Http\Controllers\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\History;
// その他
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\CarbonImmutable;

class HistoryController extends Controller
{
    public function index()
    {
        // 履歴を取得
        $histories = History::getAll()->get();
        return view('history.index')->with([
            'histories' => $histories,
        ]);
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
            $header = History::csvHeader();
            fputcsv($handle, $header);
            // 履歴を取得
            $histories = History::getAll();
            // レコードをチャンクごとに書き込む
            $histories->chunk(500, function ($histories) use ($handle) {
                // 履歴の分だけループ
                foreach($histories as $history){
                    $row = [
                        CarbonImmutable::parse($history->date)->isoFormat('Y年MM月DD日'),
                        CarbonImmutable::parse($history->time)->isoFormat('HH時mm分ss秒'),
                        $history->category,
                        $history->item_code,
                        $history->item->jan_code,
                        $history->item->item_name_1,
                        $history->item->item_name_2,
                        $history->quantity,
                        $history->comment,
                    ];
                    fputcsv($handle, $row);
                };
            });
            // ファイルを閉じる
            fclose($handle);
        });
        // ダウンロード処理
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=【スターデザイン管理システム】履歴データ_' . CarbonImmutable::now()->isoFormat('Y年MM月DD日HH時mm分ss秒') . '.csv');
        return $response;
    }
}
