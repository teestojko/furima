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
        // 現在の認証ユーザーのIDを取得
        $userId = Auth::id();

        // メッセージ履歴を取得
        // 受信者または送信者が現在のユーザーである場合のメッセージを取得
        $messages = Message::where('receiver_id', $userId)
            ->orWhere('sender_id', $userId)
            // 送信者および受信者の情報も一緒に取得
            ->with('sender', 'receiver')
            // 最新のメッセージを先頭に取得
            ->latest()
            ->get();

        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($notifications);

        $unreadNotifications = $notifications->where('is_read', false);
        // dd($unreadNotifications);

        $readNotifications = $notifications->where('is_read', true);
        // dd($readNotifications);

        // return view('notification.show', [
        //     'unreadNotifications' => $unreadNotifications,
        //     'readNotifications' => $readNotifications,
        // ]);

        return view('notification.show', compact('messages', 'notifications', 'unreadNotifications', 'readNotifications' ));
    }


    public function markAsReadAndMessageDetail($notificationId)
    {
        // 通知を取得
        $notification = Notification::findOrFail($notificationId);
        // 自分の通知か確認
        if ($notification->user_id !== Auth::id()) {
            abort(403, '不正なアクセスです');
        }
        // 通知を既読に更新
        $notification->update(['is_read' => true]);
        // 通知データをデコードしてメッセージIDを取得
        $messageData = json_decode($notification->data, true);  // JSONデコード
        // dd($messageData);
        if (!isset($messageData['message_id'])) {
            abort(404, 'メッセージIDが見つかりません');
        }
        // メッセージを取得
        $messageId = $messageData['message_id'];
        $message = Message::findOrFail($messageId);
        // メッセージ詳細を表示
        return view('notification.message_detail', [
            'message' => $message,
            'notification' => $notification,
        ]);
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
        return view('notification.message_detail', [
            'message' => $message,
            'notification' => $notification,
        ]);
    }
}
