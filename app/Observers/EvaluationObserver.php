<?php

namespace App\Observers;

use App\Models\Book;
use App\Models\Evaluation;

class EvaluationObserver
{
    /**
     * Handle the Evaluation "created" event.
     *
     * @param  \App\Models\Evaluation  $Evaluation
     * @return void
     */
    public function creating(Evaluation $evaluation)
    {

        //     $book_id=$evaluation->book_id;
        //     $allEvaluations=Evaluation::where('book_id',$book_id)->get();
        //     $evaluation=$allEvaluations->sum('value') / count($allEvaluations);

        //    $book=Book::find($book_id)->update([
        //     'rating'=>$evaluation
        //    ]);
        //  dd($book);

    }

    /**
     * Handle the Evaluation "updated" event.
     *
     * @return void
     */
    public function updated(Evaluation $Evaluation)
    {
        //
    }

    /**
     * Handle the Evaluation "deleted" event.
     *
     * @return void
     */
    public function deleted(Evaluation $Evaluation)
    {
        //
    }

    /**
     * Handle the Evaluation "restored" event.
     *
     * @return void
     */
    public function restored(Evaluation $Evaluation)
    {
        //
    }

    /**
     * Handle the Evaluation "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Evaluation $Evaluation)
    {
        //
    }
}
