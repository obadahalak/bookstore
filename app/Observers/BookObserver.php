<?php

namespace App\Observers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class BookObserver
{
    /**
     * Handle the Book "created" event.
     *
     * @return void
     */
    public function created(Book $Book)
    {
        Category::find($Book->category_id)->increment('count_of_books');
    }

    public function creating(Book $Book)
    {

    }

    /**
     * Handle the Book "updated" event.
     *
     * @param  \App\Models\Book  $Book
     * @return void
     */
    public function updated(Book $book)
    {

    }

    public function saving()
    {
        Cache::forget('books');
    }

    /**
     * Handle the Book "deleted" event.
     *
     * @return void
     */
    public function deleted(Book $Book)
    {
        //
    }

    /**
     * Handle the Book "restored" event.
     *
     * @return void
     */
    public function restored(Book $Book)
    {
        //
    }

    /**
     * Handle the Book "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Book $Book)
    {
        //
    }
}
