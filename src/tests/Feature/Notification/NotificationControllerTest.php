<?php

namespace Tests\Feature\Notification;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_notification_displays_user_notifications()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Notification::factory()->count(2)->create([
            'user_id' => $user->id,
            'is_read' => false,
        ]);
        Notification::factory()->count(1)->create([
            'user_id' => $user->id,
            'data' => json_encode(['message' => '通知テスト①']),
            'is_read' => true,
        ]);

        $response = $this->get(route('notifications-show'));

        $response->assertStatus(200);
        $response->assertViewHas('notifications');
        $response->assertViewHas('unreadNotifications');
        $response->assertViewHas('readNotifications');
    }

    public function test_mark_as_read_and_message_detail_success()
    {
        $user = User::factory()->create();
        $sender = User::factory()->create();

        $message = Message::factory()->create([
            'sender_id' => $sender->id,
            'receiver_id' => $user->id,
        ]);

        $notification = Notification::factory()->create([
            'user_id' => $user->id,
            'is_read' => false,
            'data' => json_encode(['message_id' => $message->id]),
        ]);

        $this->actingAs($user);

        $response = $this->get(route('notifications-mark-read-and-message-detail', $notification->id));

        $response->assertStatus(200);
        $this->assertTrue((bool) Notification::find($notification->id)->is_read);
        $response->assertViewIs('notification.message_detail');
        $response->assertViewHas('message');
        $response->assertViewHas('notification');
    }

    public function test_cannot_access_others_notifications()
    {
        $me = User::factory()->create();
        $other = User::factory()->create();
        $sender = User::factory()->create();

        $message = Message::factory()->create([
            'sender_id' => $sender->id,
            'receiver_id' => $other->id,
        ]);

        $notification = Notification::factory()->create([
            'user_id' => $other->id,
            'is_read' => false,
            'data' => json_encode(['message_id' => $message->id]),
        ]);

        $this->actingAs($me);

        $response = $this->get(route('notifications-mark-read-and-message-detail', $notification->id));

        $response->assertStatus(403);
    }

    public function test_message_detail_marks_as_read_and_shows_view()
    {
        $user = User::factory()->create();
        $sender = User::factory()->create();

        $message = Message::factory()->create([
            'sender_id' => $sender->id,
            'receiver_id' => $user->id,
        ]);

        $notification = Notification::factory()->create([
            'user_id' => $user->id,
            'is_read' => false,
            'data' => json_encode(['message_id' => $message->id]),
        ]);

        $this->actingAs($user);

        $response = $this->get(route('notifications-message-detail', $notification->id));

        $response->assertStatus(200);
        $this->assertTrue((bool) Notification::find($notification->id)->is_read);
        $response->assertViewIs('notification.message_detail');
    }
}
