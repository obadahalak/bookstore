<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\BooksScheduling;
use App\Mail\RememberReadBookMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class notifyReadesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
  
    
    public function __construct()
    {
       
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $schedulings= BooksScheduling::withoutGlobalScopes()->with(['user:id,email','book:id,name', 'schedulingInfos'=>function($q){
            $q->whereDay('date',now());
        }])->get();
        
        foreach($schedulings as $item){
            
            $to_user=$item->user->email;
             $message['book_name']=$item->book->name;
            foreach($item->schedulingInfos as $info){
                $message['pages']=$info->pages;
            }
          
            Mail::to($to_user)->send(
                new RememberReadBookMail($message['book_name'],$message['pages'])
            );
         
        }
    }
}
