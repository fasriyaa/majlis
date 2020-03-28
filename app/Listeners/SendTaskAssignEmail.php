<?php

namespace App\Listeners;

use App\Events\AssignTask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Mail\TaskAssignMail;

class SendTaskAssignEmail implements ShouldQueue
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
     * @param  AssignTask  $event
     * @return void
     */
    public function handle(AssignTask $event)
    {
        Mail::to($event->task->user->email)->send(new TaskAssignMail($event->task));
    }
}
