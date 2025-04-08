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
            'user_id' => User::factory()->create(), // ランダムなユーザー
            'type' => $this->faker->randomElement(['message', 'transaction', 'alert']), // ランダムな通知タイプ
            'data' => json_encode([
                'title' => $this->faker->word, // ランダムなタイトル
                'body' => $this->faker->sentence, // ランダムな本文
            ]),
            'read_at' => $this->faker->optional()->dateTimeThisYear(), // ランダムな読んだ日時
            'is_read' => $this->faker->boolean(50), // 50%の確率で既読
        ];
    }
}
