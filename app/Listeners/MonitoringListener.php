<?php

namespace App\Listeners;

use App\Eloquents\AccessPoint;
use App\Eloquents\AccessNotification;
use App\Events\Monitoring;
use App\Notifications\AccessErrorNotification;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notification;

class MonitoringListener implements ShouldQueue
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var Notification
     */
    private $accessNotification;

    /**
     * @param Client $guzzleClient
     * @param AccessNotification $accessNotification
     */
    public function __construct(Client $guzzleClient, AccessNotification $accessNotification)
    {
        $this->guzzleClient = $guzzleClient;
        $this->accessNotification = $accessNotification;
    }

    /**
     * @param Monitoring $event
     * @return void
     */
    public function handle(Monitoring $event): void
    {
        $error = $this->access($event->accessPoint->url);

        if (!is_null($error)) {
            $this->sendErrorNotification($event->accessPoint, $error);
        }
    }

    /**
     * @param string $url
     * @return string|null エラーメッセージ 接続成功ならnull
     */
    private function access(string $url): ?string
    {
        try {
            $this->guzzleClient->request('GET', $url);
            return null;

        } catch (GuzzleException $e) {
            $message = 'status:' . $e->getCode() . PHP_EOL . $e->getMessage();
            return $message;
        }
    }

    /**
     * @param AccessPoint $accessPoint
     * @param string $error
     */
    private function sendErrorNotification(AccessPoint $accessPoint, string $error): void
    {
        $accessNotifications = $this->accessNotification->all();

        Notification::send($accessNotifications, new AccessErrorNotification($accessPoint, $error));
    }
}
