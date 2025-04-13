<?php

namespace Tests\Feature\Mail;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use App\Mail\MessageReceived;
use App\Jobs\SaveNotification;

class MessageReceivedControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_send_message()
    {
        Mail::fake();
        Queue::fake();

        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $response = $this->actingAs($sender)->post("/messages/{$receiver->id}/send-email", [
            'message' => 'こんにちは！',
        ]);

        $response->assertRedirect(); // バックリダイレクトを確認
        $response->assertSessionHas('success', 'メッセージが送信されました。');

        $this->assertDatabaseHas('messages', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => 'こんにちは！',
        ]);

        Queue::assertPushed(SaveNotification::class);
        Mail::assertSent(MessageReceived::class);
    }

    public function test_validation_error_if_message_is_missing()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $response = $this->actingAs($sender)->post("/messages/{$receiver->id}/send-email", [
            'message' => '', // 空のメッセージ
        ]);

        $response->assertSessionHasErrors('message');
    }
}
