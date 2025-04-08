<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\DeliveryMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'category_id' => Category::factory()->create(),
            'condition_id' => Condition::factory()->create(),
            'delivery_method_id' => DeliveryMethod::factory()->create(),
            'name' => $this->faker->word(),
            'detail' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(1000, 10000),
            'stock' => $this->faker->numberBetween(1, 100),
        ];
    }
}
