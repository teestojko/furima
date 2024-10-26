<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_statuses')->insert([
            ['name' => '保留中'],
            ['name' => '完了'],
            ['name' => '発送済'],
            ['name' => 'キャンセル済'],
        ]);
    }
}
