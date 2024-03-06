<?php

namespace App\Http\Controllers\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\History;

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
}
