<?php

namespace App\Http\Controllers\Top;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\Item;
use App\Models\History;
// その他
use Illuminate\Support\Facades\DB;

class TopController extends Controller
{
    public function index()
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
                    ->get();
        return view('top')->with([
            'items' => $items,
        ]);
    }
}
