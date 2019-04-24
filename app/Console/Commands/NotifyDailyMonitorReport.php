<?php

namespace App\Console\Commands;

use App\Eloquents\AccessNotification;
use App\Eloquents\ErrorLog;
use App\Notifications\DailyReportHasErrorNotification;
use App\Notifications\DailyReportNoErrorNotification;
use Illuminate\Console\Command;
use Notification;

class NotifyDailyMonitorReport extends Command
{
    /**
     * @var string
     */
    protected $signature = 'monitor:report';

    /**
     * @var string
     */
    protected $description = 'send report to slack message';

    /**
     * @var AccessNotification
     */
    private $accessNotification;

    /**
     * @var ErrorLog
     */
    private $errorLog;

    /**
     * @param AccessNotification $accessNotification
     * @param ErrorLog $errorLog
     */
    public function __construct(AccessNotification $accessNotification, ErrorLog $errorLog)
    {
        parent::__construct();

        $this->accessNotification = $accessNotification;
        $this->errorLog = $errorLog;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        if ($this->errorLog->hasTodayError()) {
            Notification::send(
                $this->accessNotification->all(),
                new DailyReportHasErrorNotification($this->errorLog->today()->with('accessPoint')->get())
            );
        } else {
            Notification::send($this->accessNotification->all(), new DailyReportNoErrorNotification());
        }
    }
}
