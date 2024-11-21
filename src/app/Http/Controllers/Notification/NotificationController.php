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

        // 未読通知の取得
        $notifications = Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->latest()
            ->get();


        return view('Notification.show', compact('messages', 'notifications'));
    }

    // public function index()
    // {
    //     $notifications = Notification::where('user_id', Auth::id())
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     return view('notifications.index', compact('notifications'));
    // }

    // public function markAsRead($id)
    // {
    //     $notification = Notification::findOrFail($id);
    //     $notification->update(['read_at' => now()]);

    //     return redirect()->back();
    // }
}
