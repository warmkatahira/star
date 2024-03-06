<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\History;

class HistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        History::create([
            'date' => '2024-03-05',
            'time' => '10:10:34',
            'category' => '発注',
            'item_code' => '4549493000389',
            'quantity' => 10,
            'comment' => '',
        ]);
        History::create([
            'date' => '2024-03-05',
            'time' => '16:40:11',
            'category' => '発注',
            'item_code' => '4549493000402',
            'quantity' => 4,
            'comment' => '',
        ]);
        History::create([
            'date' => '2024-03-06',
            'time' => '12:10:34',
            'category' => '発注',
            'item_code' => '4549493000402',
            'quantity' => 2,
            'comment' => '',
        ]);
    }
}
