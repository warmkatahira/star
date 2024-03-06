<?php

namespace App\Http\Controllers\QuantityChange;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\Item;
use App\Models\History;
// その他
use Carbon\CarbonImmutable;

class QuantityChangeController extends Controller
{
    public function index()
    {
        // 商品マスタを取得
        $items = Item::getAll()->get();
        return view('quantity_change.index')->with([
            'items' => $items,
        ]);
    }

    public function change(Request $request)
    {   
        // 現在の日時を取得
        $now = CarbonImmutable::now();
        // 交換前の情報を取得
        $before_source_item = Item::where('item_code', $request->source_item_code)->first();
        $before_target_item = Item::where('item_code', $request->source_item_code)->first();
        // 初回パッケージ数量を更新
        // 交換元(減らす)
        Item::where('item_code', $request->source_item_code)->decrement('first_package_quantity', $request->source_quantity);
        // 交換先(増やす)
        Item::where('item_code', $request->target_item_code)->increment('first_package_quantity', $request->target_quantity);
        // 履歴テーブルに追加
        History::create([
            'date' => $now->format('Y-m-d'),
            'time' => $now->format('H:i:s'),
            'category' => '数量交換',
            'item_code' => $request->source_item_code,
            'quantity' => '-' . $request->source_quantity,
            'comment' => '「' . $request->target_item_code . '」を「' . $request->target_quantity . '」個増',
        ]);
        History::create([
            'date' => $now->format('Y-m-d'),
            'time' => $now->format('H:i:s'),
            'category' => '数量交換',
            'item_code' => $request->target_item_code,
            'quantity' => $request->target_quantity,
            'comment' => '「' . $request->source_item_code . '」を「' . $request->source_quantity . '」個減',
        ]);
        return redirect()->route('top.index')->with([
            'alert_type' => 'success',
            'alert_message' => '数量交換を実施しました。',
        ]);
    }
}
