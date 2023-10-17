<?php

namespace App\Listeners;

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
        $book = auth()->user()->userActivities();
        $book = $book->where('book_id', $event->book);
        $book->exists() ? $book->increment('count_of_visits') : $book->attach($event->book);
    }
}
