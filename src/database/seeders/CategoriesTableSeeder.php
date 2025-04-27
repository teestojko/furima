<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::query()->delete();

        DB::table('categories')->insert([
            ['name' => '財布'],
            ['name' => 'バッグ'],
            ['name' => '小物入れ'],
            ['name' => 'ネイルチップ'],
            ['name' => 'キーケース']
        ]);
    }
}
