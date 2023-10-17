<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    public function saving(User $user)
    {
        Cache::forget($user->email);
    }

    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @return void
     */
    public function updated(User $user)
    {
        // Cache::forget($user->email);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
