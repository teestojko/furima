<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;

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

    public function __construct($userId, $type, $data)
    {
        $this->userId = $userId;
        $this->type = $type;
        $this->data = $data;
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
    }
}
