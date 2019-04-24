<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class DailyReportHasErrorNotification extends Notification
{
    use Queueable;

    /**
     * @var Collection
     */
    private $errorLogs;

    /**
     * DailyReportHasErrorNotification constructor.
     * @param Collection $errorLogs [ErrorLog with AccessPoint]
     */
    public function __construct(Collection $errorLogs)
    {
        $this->errorLogs = $errorLogs;
    }

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
            ->from(config('monitoring.slack_notification_username'), ':warning:')
            ->to(config('monitoring.slack_channel'))
            ->content(today()->format('Y-m-d') . 'は' . $this->errorLogs->count() . '件のエラーが検出されました')
            ->attachment(function (SlackAttachment $attachment) {
                $attachment->content($this->buildErrorMessage());
            });
    }

    /**
     * @return string
     */
    private function buildErrorMessage(): string
    {
        $message = '';

        foreach ($this->errorLogs as $log) {
            $message .= $log->created_at->format('Y-m-d H:i:s') . ':' . $log->accessPoint->name . PHP_EOL;
        }

        return $message;
    }
}
