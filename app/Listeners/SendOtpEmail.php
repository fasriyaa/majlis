<?php

namespace App\Listeners;

use App\Events\OtpToken;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Mail\OtpTokenMail;

class SendOtpEmail implements ShouldQueue
{
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
     * @param  OtpToken  $event
     * @return void
     */
    public function handle(OtpToken $event)
    {
        Mail::to($event->user->email)->send(new OtpTokenMail($event->user));
    }
}
