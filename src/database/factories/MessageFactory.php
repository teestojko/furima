<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Message;

class MessageFactory extends Factory
{
    protected $model = Message::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            // sender_id, receiver_id は Seeder 側で指定する為、ここでは作成しない
            'message' => $this->faker->sentence(),
            'read_at' => $this->faker->optional()->dateTime(),
        ];
    }
}
