<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewAnnouncementNotification;
use App\Events\AnnouncementCreated;

class SendNewAnnouncementNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle(AnnouncementCreated $event)
    {
        if($event->announcement->department_id == null){
            $all_students = User::where('student_id', '!=', null)->get();

            Notification::send($all_students, new NewAnnouncementNotification($event->announcement));
        }else{
            $dept_students = User::where('student_id', '!=', null)->where('department_id', $event->announcement->department_id)->get();

            Notification::send($dept_students, new NewAnnouncementNotification($event->announcement));
        }    
    }
}
