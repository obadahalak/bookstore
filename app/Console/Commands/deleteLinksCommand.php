<?php

namespace App\Console\Commands;

use App\Models\Link;
use Illuminate\Console\Command;

class deleteLinksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-inactive-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete all links has been used';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Link::where('active',false)->delete();
    }
}
