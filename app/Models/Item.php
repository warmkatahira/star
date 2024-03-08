<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'item_code';
    // オートインクリメント無効化
    public $incrementing = false;
    // 操作可能なカラムを定義
    protected $fillable = [
        'item_code',
        'jan_code',
        'item_name_1',
        'item_name_2',
        'first_package_quantity',
    ];
    // 全てを取得
    public static function getAll()
    {
        return self::orderBy('item_code', 'asc');
    }
    // ヘッダーを定義
    public static function csvHeader()
    {
        return [
            '商品コード',
            'JANコード',
            '商品名1',
            '商品名2',
            '初回パッケージ数量',
            '発注済み数量',
            '初回パッケージ残数',
        ];
    }
}
