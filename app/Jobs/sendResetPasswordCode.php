<?php

namespace App\Jobs;

use App\Mail\RestPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class sendResetPasswordCode implements ShouldQueue
{
    use Batchable,Dispatchable ,  InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $email;

    public function __construct($email)
    {
        $this->email = $email;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toUser = $this->generateCode($this->email);

        Mail::to($this->email)->send(new RestPasswordMail($toUser));
    }

    private function generateCode($email)
    {

        $code = Str::random(20);

        while (User::where('rest_token', $code)->first()) {
            $code = Str::random(20);
        }
        $user = User::where('email', $email)->first();

        $user->update([
            'rest_token' => $code,
            'reset_token_expiration' => Carbon::now()->addMinutes(10),
        ]);

        return $code;
    }
}
