<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Product;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::factory()->count(5)->create();

        $products = Product::all();

        // 各プロダクトにタグをランダムに紐づけ
        foreach ($products as $product) {
            // ランダムにタグを1～3個選び、紐づける
            $product->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
