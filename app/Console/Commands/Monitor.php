<?php

namespace App\Console\Commands;

use App\Eloquents\AccessPoint;
use App\Events\Monitoring;
use Illuminate\Console\Command;

class Monitor extends Command
{
    /**
     * @var string
     */
    protected $signature = 'monitor:all';

    /**
     * @var string
     */
    protected $description = 'monitoring';

    /**
     * @var AccessPoint
     */
    private $accessPoint;

    /**
     * @param AccessPoint $accessPoint
     */
    public function __construct(AccessPoint $accessPoint)
    {
        parent::__construct();

        $this->accessPoint = $accessPoint;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->monitorAll();
    }

    /**
     * 全件モニタリング
     * まずはこれだけ
     */
    private function monitorAll(): void
    {
        foreach ($this->accessPoint->all() as $accessPoint) {
            event(new Monitoring($accessPoint));
        }
    }
}
