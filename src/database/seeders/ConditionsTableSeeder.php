<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Condition;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Condition::query()->delete();

        DB::table('conditions')->insert([
            ['name' => '新品'],
            ['name' => '中古']
        ]);
    }
}
