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
        // メッセージ履歴
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

        return view('Notification.show', [
            'unreadNotifications' => $unreadNotifications,
            'readNotifications' => $readNotifications,
        ]);
        return view('Notification.show', compact('messages', 'notifications'));
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::findOrFail($notificationId);

        // 自分の通知のみ更新
        if ($notification->user_id === Auth::id()) {
            $notification->update(['is_read' => true]);
        }

        return redirect()->back()->with('success', '通知が既読になりました');
    }

    public function messageDetail($notificationId)
    {
        // 通知を取得
        $notification = Notification::findOrFail($notificationId);

        // 自分の通知か確認
        if ($notification->user_id !== Auth::id()) {
            abort(403, '不正なアクセスです');
        }

        // 通知を既読に更新
        $notification->update(['is_read' => true]);

        // 通知に関連するメッセージを取得
        $messageId = $notification->data['message_id'];  // 例：通知データにメッセージIDが含まれていると仮定
        $message = Message::findOrFail($messageId);

        return view('Notification.message_detail', [
            'message' => $message,
            'notification' => $notification,
        ]);
    }
}
