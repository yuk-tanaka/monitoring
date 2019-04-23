<?php

namespace App\Notifications;

use App\Eloquents\AccessPoint;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class AccessErrorNotification extends Notification
{
    use Queueable;
    /**
     * @var AccessPoint
     */
    private $accessPoint;
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @param AccessPoint $accessPoint
     * @param string $errorMessage
     */
    public function __construct(AccessPoint $accessPoint, string $errorMessage)
    {
        $this->accessPoint = $accessPoint;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    /**
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->error()
            ->line($this->accessPoint->name . 'へのアクセスでエラーが発生しました')
            ->line($this->errorMessage);
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
            ->content($this->accessPoint->name . 'へのアクセスでエラーが発生しました')
            ->attachment(function (SlackAttachment $attachment) {
                $attachment->content($this->errorMessage);
            });
    }
}
