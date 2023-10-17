<?php

namespace App\Observers;

use App\Models\category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    /**
     * Handle the category "created" event.
     *
     * @return void
     */
    public function created(category $category)
    {
        //
    }

    /**
     * Handle the category "updated" event.
     *
     * @return void
     */
    public function updated(category $category)
    {
        //
    }

    public function saved(category $category)
    {
        Cache::forget('categories');
    }

    /**
     * Handle the category "deleted" event.
     *
     * @return void
     */
    public function deleted(category $category)
    {
        //
    }

    /**
     * Handle the category "restored" event.
     *
     * @return void
     */
    public function restored(category $category)
    {
        //
    }

    /**
     * Handle the category "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(category $category)
    {
        //
    }
}
