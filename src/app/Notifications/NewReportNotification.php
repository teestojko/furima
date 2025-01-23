<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReportNotification extends Notification
{
    use Queueable;

    protected $report;

    /**
     * 通知のインスタンスを新規作成
     *
     * @param array $report
     */

    public function __construct($report)
    {
        $this->report = $report;
    }

    /**
     * 通知の配信チャンネルを取得
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // 通知をメールとデータベースの両方で送信
        return ['mail', 'database'];
    }

    /**
     * メール通知の内容を作成
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('新しい通報が送信されました')
            ->line('新しい通報が送信されました。以下の内容をご確認ください。')
            ->line('通報理由: ' . $this->report->reason)
            ->action('詳細を確認する', url('/admin/reports/' . $this->report->id))
            ->line('この通報に対処してください。');
    }

    /**
     * データベース通知の内容を作成
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'report_id' => $this->report['id'],
            'reason' => $this->report['reason'],
            'reported_product_id' => $this->report['reported_product_id'],
            'reported_user_id' => $this->report['reported_user_id'],
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function toArray($notifiable)
    // {
    //     return [
    //         'report_id' => $this->report->id,
    //         'reason' => $this->report->reason,
    //         'reported_product_id' => $this->report->reported_product_id,
    //         'reported_user_id' => $this->report->reported_user_id,
    //     ];
    // }
}



