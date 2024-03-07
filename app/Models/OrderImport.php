<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderImport extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'order_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'item_code',
        'quantity',
        'order_file_name',
    ];
    // 全てを取得
    public static function getAll()
    {
        return self::orderBy('order_id', 'asc');
    }
    // itemsテーブルとのリレーション
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_code', 'item_code');
    }
}
