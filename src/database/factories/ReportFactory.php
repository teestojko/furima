<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Report;
use App\Models\Product;
use App\Models\User;

class ReportFactory extends Factory
{
    protected $model = Report::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reported_product_id' => Product::factory()->create(),
            'reported_user_id' => User::factory()->create(),
            'reporter_user_id' => User::factory()->create(),
            'reason' => $this->faker->sentence,
            'comment' => $this->faker->paragraph,
        ];
    }
}
