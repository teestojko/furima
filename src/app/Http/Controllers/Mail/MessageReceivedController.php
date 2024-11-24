<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\MessageReceived;
use Illuminate\Support\Facades\Mail;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SaveNotification;

class MessageReceivedController extends Controller
{
    public function store(Request $request, $receiverId)
    {
        // 入力バリデーション
        $request->validate(['message' => 'required|string']);
        // メッセージ作成
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);
        $messageId = $message->id;
        // 通知データを非同期で保存
        $notificationData = [
            'message' => $message->message,
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message_id' => $messageId,
        ];
        SaveNotification::dispatch(
            $receiverId,         // 通知を受け取るユーザーID
            'message',           // 通知の種類
            $notificationData,
            Auth::user()   // 通知の内容
        );
        return redirect()->back()->with('success', 'メッセージが送信されました。');
    }
}
