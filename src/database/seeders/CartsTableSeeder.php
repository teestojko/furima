<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();
        $products = \App\Models\Product::all();

        $combinations = collect();

        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $product = $products->random();

            $key = $user->id . '-' . $product->id;
            if ($combinations->contains($key)) {
                continue;
            }

            try {
                \App\Models\Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                ]);
                $combinations->push($key);
            } catch (\Exception $e) {
                logger()->error('Cart insert failed: ' . $e->getMessage());
            }
        }
    }
}
