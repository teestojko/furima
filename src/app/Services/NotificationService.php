<?php

namespace App\Services;

class NotificationService
{
    /**
     * トランザクション通知を作成
     */
    public function createTransactionNotification($sellerId, $order)
    {
        Notification::create([
            'user_id' => $sellerId,
            'type' => 'transaction',
            'data' => [
                'message' => 'あなたの商品が購入されました！',
                'order_id' => $order->id,
            ],
        ]);
    }

    /**
     * メッセージ通知を作成
     */
    public function createMessageNotification($receiverId, $senderName)
    {
        Notification::create([
            'user_id' => $receiverId,
            'type' => 'message',
            'data' => [
                'message' => $senderName . ' さんから新しいメッセージが届きました。',
                'sender_id' => auth()->id(),
            ],
        ]);
    }
}
