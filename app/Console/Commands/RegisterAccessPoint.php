<?php

namespace App\Console\Commands;

use App\Eloquents\AccessPoint;
use Illuminate\Console\Command;

class RegisterAccessPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:ap {name} {url}';

    /**
     * @var string
     */
    protected $description = 'create AccessPoint
    name: string
    url: string';

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
        $accessPoint = $this->accessPoint->create([
            'name' => $this->argument('name'),
            'url' => $this->argument('url'),
        ]);

        $this->info($accessPoint);
    }
}
