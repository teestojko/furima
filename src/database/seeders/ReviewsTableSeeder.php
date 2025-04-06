<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();

        Review::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}
