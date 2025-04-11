<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class MessageController extends Controller
{
    public function index($userId)
    {
        // 受信者のユーザー情報を取得
        $receiverUser = User::findOrFail($userId);

        // メッセージの履歴を取得（必要に応じてメッセージの取得方法を変更）
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $userId);
        })
        ->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', auth()->id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

        $notifications = Notification::where('user_id', auth()->id())
            ->where('is_read', false)  // 未読通知の例
            ->get();

        return view('message.message', [
            'messages' => $messages,
            'receiverId' => $userId,  // 受信者IDをビューに渡す
            'receiverUser' => $receiverUser, // 受信者のユーザー情報も渡す
            'notifications' => $notifications, // 通知データも渡す
        ]);
    }

}

