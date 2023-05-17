<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Mail\RestPasswordMail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class sendResetPasswordCode implements ShouldQueue
{
    use Dispatchable,Batchable ,  InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
   
    public $user;
    public function __construct($user)
    {
        $this->user = $user;
      
    }
    private function generateCode($email){
        $code=Str::random(20);
        $users=User::where('rest_token',$code)->first();
        while($users){
            $code=Str::random(20);
        }
        $user=User::where('email',$email)->first();
      
        $user->update([ 
            'rest_token'=>$code,
            'reset_token_expiration'=>Carbon::now()->addMinutes(30),
        ]);
        return $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

     
    public function handle()
    {
       $ToUser=$this->generateCode($this->user);
        Mail::to($this->user)->send(new RestPasswordMail($ToUser));
    }
}
