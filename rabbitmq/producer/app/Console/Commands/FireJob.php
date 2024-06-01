<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\JobCreated;

class FireJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fire JobCreated';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo "Job Has Been Fired" . PHP_EOL;
        JobCreated::dispatch(['somekey' => 'somevalue']);
    }
}
