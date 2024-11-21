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

        return view('Message.message', [
            'messages' => $messages,
            'receiverId' => $userId,  // 受信者IDをビューに渡す
            'receiverUser' => $receiverUser  // 受信者のユーザー情報も渡す
        ]);
    }

    public function store(Request $request, $receiverId)
    {
        $request->validate(['message' => 'required|string']);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'メッセージが送信されました。');
    }
}
