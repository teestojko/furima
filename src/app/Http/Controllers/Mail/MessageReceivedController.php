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
    public function create($receiverId)
    {
        $receiverUser = User::findOrFail($receiverId);

        return view('message.message', [
            'receiverId' => $receiverId,
            'receiverUser' => $receiverUser,
        ]);
    }

    public function store(Request $request, $receiverId)
    {
        $request->validate(['message' => 'required|string']);
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);
        $messageId = $message->id;
        $notificationData = [
            'message' => $message->message,
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message_id' => $messageId,
        ];
        SaveNotification::dispatch(
            $receiverId,
            'message',
            $notificationData,
            Auth::user()
        );

        $receiver = User::find($receiverId);
        Mail::to($receiver->email)->send(new MessageReceived($message));

        return redirect()->back()->with('success', 'メッセージが送信されました。');
    }
}
