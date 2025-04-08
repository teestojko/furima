<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\OrderStatus;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::query()->delete();

        DB::table('order_statuses')->insert([
            ['name' => '保留中'],
            ['name' => '完了'],
            ['name' => '発送済'],
            ['name' => 'キャンセル済'],
        ]);

        // OrderStatus::factory()->count(1)->create();
    }
}
