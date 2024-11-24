<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageReceived;

class SaveNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param int $userId
     * @param string $type
     * @param array $data
     * @return void
     */

    protected $userId;
    protected $type;
    protected $data;
    protected $sender;

    public function __construct($userId, $type, $data, $sender)
    {
        $this->userId = $userId;
        $this->type = $type;
        $this->data = $data;
        $this->sender = $sender;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 通知データを保存
        Notification::create([
            'user_id' => $this->userId,
            'type' => $this->type,
            'data' => json_encode($this->data),
            'is_read' => false,
        ]);

        // mailtrap送信処理
        $user = User::find($this->userId); // 通知の受信者情報を取得
        if ($user && isset($this->data['message'])) {
            // Mailableクラスを使ってメール送信
            $messageData = (object) [
                'message' => $this->data['message'],
                'sender' => $this->sender,
            ];
            Mail::to($user->email)->send(new MessageReceived($messageData));
        }
    }
}
