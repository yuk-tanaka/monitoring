<?php

namespace App\Events;

use App\Eloquents\AccessPoint;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Monitoring
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var AccessPoint
     */
    public $accessPoint;

    /**
     * @param AccessPoint $accessPoint
     */
    public function __construct(AccessPoint $accessPoint)
    {
        $this->accessPoint = $accessPoint;
    }
}
