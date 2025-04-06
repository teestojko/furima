<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\DeliveryMethod;

class DeliveryMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliveryMethod::query()->delete();

        DB::table('delivery_methods')->insert([
            ['name' => '通常配送'],
            ['name' => '速達配送']
        ]);

        DeliveryMethod::factory()->count(1)->create();
    }
}
