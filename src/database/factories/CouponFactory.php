<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;

class CouponFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $discountType = $this->faker->randomElement(['fixed', 'percentage']);

        return [
            'user_id' => $this->faker->optional()->randomElement(User::pluck('id')->toArray()),
            'code' => strtoupper(Str::random(8)),
            'discount' => $discountType === 'fixed'
                ? $this->faker->numberBetween(100, 2000)
                : $this->faker->randomFloat(1, 5, 50),
            'discount_type' => $discountType,
            'valid_from' => now()->subDays(rand(0, 5)),
            'valid_until' => now()->addDays(rand(1, 30)),
            'is_active' => $this->faker->boolean(80),
            'is_used' => $this->faker->boolean(30),
        ];
    }

    public function valid(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => true,
                'is_used' => false,
                'valid_from' => now()->subDay(),
                'valid_until' => now()->addDay(),
            ];
        });
    }
}
