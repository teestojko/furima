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
        $users = User::all();

        if ($users->count() < 2) {
            $this->command->info('メッセージを作成するにはユーザーが2人以上必要です。');
            return;
        }

        foreach ($users as $sender) {
            foreach ($users as $receiver) {
                if ($sender->id === $receiver->id) {
                    continue;
                }

                // やり取りの回数（1〜3通をランダムで）
                $messageCount = rand(1, 3);

                for ($i = 0; $i < $messageCount; $i++) {
                    // 交互にやり取り（偶数: sender→receiver、奇数: receiver→sender）
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
