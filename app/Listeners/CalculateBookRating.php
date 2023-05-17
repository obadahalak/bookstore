<?php

namespace App\Listeners;

use App\Models\Book;
use App\Events\Evaluated;
use App\Jobs\sendMailJob;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CalculateBookRating implements ShouldQueue
{
    public $connection='database';
    
    // public $queue='listeners';

    // public $delay=10;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle( Evaluated $event)
    {
        $allEvaluations=Evaluation::where('book_id',$event->book_id)->get();
       $evaluation=$allEvaluations->sum('value') / count($allEvaluations);
       Book::find($event->book_id)->update([
        'rating'=>$evaluation
       ]);
    
    
       
    }
}
