<?php

namespace App\Console\Commands;

// use App\Jobs\notifyReadesJob;
use Illuminate\Console\Command;

class RememberReadersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remember-readers-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \App\Jobs\notifyReadesJob::dispatch();
    }
}
