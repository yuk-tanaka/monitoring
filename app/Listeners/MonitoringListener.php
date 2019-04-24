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
            $this->createErrorLog($event->accessPoint, $error);
            $this->sendErrorNotification($event->accessPoint, $error);
        }
    }

    /**
     * @param string $url
     * @return GuzzleException|null 接続成功ならnull
     */
    private function access(string $url): ?GuzzleException
    {
        try {
            $this->guzzleClient->request('GET', $url);
            return null;

        } catch (GuzzleException $e) {
            return $e;
        }
    }

    /**
     * @param AccessPoint $accessPoint
     * @param GuzzleException $error
     */
    private function sendErrorNotification(AccessPoint $accessPoint, GuzzleException $error): void
    {
        $accessNotifications = $this->accessNotification->all();

        $message = 'status:' . $error->getCode() . PHP_EOL . $error->getMessage();

        Notification::send($accessNotifications, new AccessErrorNotification($accessPoint, $message));
    }

    /**
     * @param AccessPoint $accessPoint
     * @param GuzzleException $error
     */
    private function createErrorLog(AccessPoint $accessPoint, GuzzleException $error): void
    {
        $accessPoint->errorLogs()->create([
            'status' => $error->getCode(),
            'description' => $error->getMessage(),
        ]);
    }
}
