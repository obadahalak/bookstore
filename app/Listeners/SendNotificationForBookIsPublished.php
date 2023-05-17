<?php

namespace App\Listeners;

use App\Models\Notification;
use App\Events\PublishedBook;
use App\enum\NotificationMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificationForBookIsPublished implements ShouldQueue
{
    public $connection = 'database';
   
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
    public function handle(PublishedBook $event)
    {
        
      Notification::create([
        'user_id'=>$event->book->user_id,
        'message'=>Notification::AcceptanceMessage($event->book->name),
    ]);
    
}
}
