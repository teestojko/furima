<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Message;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = rand(2, 5);

        $users = User::inRandomOrder()->take($userCount)->get();

        if ($users->count() < 2) {
            $this->command->info('メッセージを作成するにはユーザーが2人以上必要です。');
            return;
        }

        foreach ($users as $sender) {
            foreach ($users as $receiver) {
                if ($sender->id === $receiver->id) {
                    continue;
                }

                $messageCount = rand(1, 3);

                for ($i = 0; $i < $messageCount; $i++) {
                    if ($i % 2 === 0) {
                        Message::factory()->create([
                            'sender_id' => $sender->id,
                            'receiver_id' => $receiver->id,
                        ]);
                    } else {
                        Message::factory()->create([
                            'sender_id' => $receiver->id,
                            'receiver_id' => $sender->id,
                        ]);
                    }
                }
            }
        }
    }
}
