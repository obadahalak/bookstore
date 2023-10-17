<?php

namespace App\Observers;

use App\Models\SchedulingInfo;
use BookScheduleService;

class SchedulingInfoObserver
{
    /**
     * Handle the SchedulingInfo "created" event.
     */
    public function creating(SchedulingInfo $schedulingInfo): void
    {

    }

    /**
     * Handle the SchedulingInfo "updated" event.
     */
    public function updated(SchedulingInfo $schedulingInfo): void
    {

        $query = SchedulingInfo::where('books_scheduling_id', $schedulingInfo->books_scheduling_id);
        $all_of_tasks = $query->count();
        $completed_tasks = $query->where('status', true)->count();
        if ($all_of_tasks == $completed_tasks) {
            BookScheduleService::schedulingFinesh($schedulingInfo->books_scheduling_id);
        }

    }

    /**
     * Handle the SchedulingInfo "deleted" event.
     */
    public function deleted(SchedulingInfo $schedulingInfo): void
    {
        //
    }

    /**
     * Handle the SchedulingInfo "restored" event.
     */
    public function restored(SchedulingInfo $schedulingInfo): void
    {
        //
    }

    /**
     * Handle the SchedulingInfo "force deleted" event.
     */
    public function forceDeleted(SchedulingInfo $schedulingInfo): void
    {
        //
    }
}
