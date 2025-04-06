<?php

namespace Database\Factories;

use App\Models\DeliveryMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryMethodFactory extends Factory
{
    protected $model = DeliveryMethod::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
        ];
    }
}
