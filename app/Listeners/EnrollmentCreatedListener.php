<?php

namespace App\Listeners;

use App\Events\EnrollmentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\EnrollmentCreatedNotification;
use Illuminate\Support\Facades\Notification;

class EnrollmentCreatedListener
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
     * @param  EnrollmentCreated  $event
     * @return void
     */
    public function handle(EnrollmentCreated $event)
    {
        //Mail Notofication
        Notification::send($event->enrollment->student, new EnrollmentCreatedNotification($event->enrollment));
    }
}
