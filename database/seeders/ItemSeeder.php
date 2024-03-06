<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::create([
            'item_code' => '4549493000389',
            'jan_code' => '4549493000389',
            'item_name_1' => '耳用　医療用ステンレス',
            'item_name_2' => '7M101WL　ガーネット',
            'first_package_quantity' => 30,
        ]);
        Item::create([
            'item_code' => '4549493000396',
            'jan_code' => '4549493000396',
            'item_name_1' => '耳用　医療用ステンレス',
            'item_name_2' => '7M102WL　アメジスト',
            'first_package_quantity' => 30,
        ]);
        Item::create([
            'item_code' => '4549493000402',
            'jan_code' => '4549493000402',
            'item_name_1' => '耳用　医療用ステンレス',
            'item_name_2' => '7M103WL　アクアマリン',
            'first_package_quantity' => 30,
        ]);
    }
}
