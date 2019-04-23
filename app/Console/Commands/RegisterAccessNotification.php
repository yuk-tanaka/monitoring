<?php

namespace App\Console\Commands;

use App\Eloquents\AccessNotification;
use Illuminate\Console\Command;

class RegisterAccessNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:an {name} {email?} {slack?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create AccessNotification
    name: string
    email: string|nullable
    slack: string|nullable slack url';

    /**
     * @var AccessNotification
     */
    private $accessNotification;

    /**
     * @param AccessNotification $accessNotification
     */
    public function __construct(AccessNotification $accessNotification)
    {
        parent::__construct();
        $this->accessNotification = $accessNotification;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $accessNotification = $this->accessNotification->create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'slack' => $this->argument('slack'),
        ]);

        $this->info($accessNotification);
    }
}
