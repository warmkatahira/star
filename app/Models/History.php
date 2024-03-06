<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'history_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'date',
        'time',
        'category',
        'item_code',
        'quantity',
        'comment',
    ];
    // 全てを取得
    public static function getAll()
    {
        return self::orderBy('date', 'desc')->orderBy('time', 'desc');
    }
    // itemsテーブルとのリレーション
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_code', 'item_code');
    }
}
