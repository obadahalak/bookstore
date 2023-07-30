<?php

namespace App\Listeners;

use App\Events\StoreBookEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncreaseUserBooksEvent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(StoreBookEvent $event): void
    {
        $event->user->increment('count_of_books');
    }
}
