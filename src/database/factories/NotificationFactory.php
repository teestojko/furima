<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notification;
use App\Models\User;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'type' => $this->faker->randomElement(['message', 'transaction', 'alert']),
            'data' => json_encode([
                'title' => $this->faker->word,
                'body' => $this->faker->sentence,
            ]),
            'read_at' => $this->faker->optional()->dateTimeThisYear(),
            'is_read' => $this->faker->boolean(50),
        ];
    }
}
