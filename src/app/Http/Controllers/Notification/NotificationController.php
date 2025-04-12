<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class NotificationController extends Controller
{
    public function showNotification()
    {
        $userId = Auth::id();
        $messages = Message::where('receiver_id', $userId)
            ->orWhere('sender_id', $userId)
            ->with('sender', 'receiver')
            ->latest()
            ->get();
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        $unreadNotifications = $notifications->where('is_read', false);
        $readNotifications = $notifications->where('is_read', true);

        return view('notification.show', compact('messages', 'notifications', 'unreadNotifications', 'readNotifications' ));
    }

    public function markAsReadAndMessageDetail($notificationId)
    {
        $notification = Notification::findOrFail($notificationId);
        if ($notification->user_id !== Auth::id()) {
            abort(403, '不正なアクセスです');
        }
        $notification->update(['is_read' => true]);
        $messageData = json_decode($notification->data, true);
        if (!isset($messageData['message_id'])) {
            abort(404, 'メッセージIDが見つかりません');
        }
        $messageId = $messageData['message_id'];
        $message = Message::findOrFail($messageId);

        return view('notification.message_detail', [
            'message' => $message,
            'notification' => $notification,
        ]);
    }

    public function messageDetail($notificationId)
    {
        $notification = Notification::findOrFail($notificationId);
        if ($notification->user_id !== Auth::id()) {
            abort(403, '不正なアクセスです');
        }
        $notification->update(['is_read' => true]);
        $messageId = $notification->data['message_id'];
        $message = Message::findOrFail($messageId);

        return view('notification.message_detail', [
            'message' => $message,
            'notification' => $notification,
        ]);
    }
}

