<?php

namespace App\Listeners;

use App\Models\UserActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddBookToUserActivityListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        UserActivity::create([
            'user_id'=>auth()->id(),
            'book_id'=>$event->book
        ]);
    }
}
