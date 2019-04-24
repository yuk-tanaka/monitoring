<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class DailyReportNoErrorNotification extends Notification
{
    use Queueable;

    /**
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * @param mixed $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable): SlackMessage
    {
        return (new SlackMessage())
            ->from(config('monitoring.slack_notification_username'), ':o:')
            ->to(config('monitoring.slack_channel'))
            ->content(today()->format('Y-m-d') . 'はエラー検出されませんでした');
    }
}
