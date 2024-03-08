<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemImport extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'item_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'item_code',
        'jan_code',
        'item_name_1',
        'item_name_2',
        'first_package_quantity',
        'total_order_quantity',
        'first_package_remaining',
    ];
    // ヘッダーを定義
    public static function csvHeader_EN()
    {
        return [
            'item_code',
            'jan_code',
            'item_name_1',
            'item_name_2',
            'first_package_quantity',
            'total_order_quantity',
            'first_package_remaining',
        ];
    }
}
