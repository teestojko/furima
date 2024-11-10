<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\MessageReceived;
use Illuminate\Support\Facades\Mail;
use App\Models\Message;
use App\Models\User;

class MessageReceivedController extends Controller
{
    public function store(Request $request, $receiverId)
    {
        $request->validate(['message' => 'required|string']);
        // メッセージの保存処理
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);

        // メール送信
        $receiver = User::findOrFail($receiverId);
        Mail::to($receiver->email)->send(new MessageReceived($message));

        return back()->with('success', 'メッセージが送信されました。');
    }
}
