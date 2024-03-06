<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\Item;

class ManagementController extends Controller
{
    public function index()
    {
        // 商品マスタを全て取得
        $items = Item::getAll()->get();
        return view('management.index')->with([
            'items' => $items,
        ]);
    }
}
