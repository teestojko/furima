<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'product_id' => Product::factory()->create(),
            'stars' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(15),
        ];
    }
}
