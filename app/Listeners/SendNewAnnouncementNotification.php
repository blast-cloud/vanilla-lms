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
        if(($event->announcement->department_id == null) && ($event->announcement->course_class_id == null)){
            $all_students = User::where('student_id', '!=', null)->get();

            Notification::send($all_students, new NewAnnouncementNotification($event->announcement));
        }elseif(($event->announcement->department_id != null) && ($event->announcement->course_class_id == null)){
            $dept_students = User::where('student_id', '!=', null)
                                 ->where('department_id', $event->announcement->department_id)
                                 ->get();

            Notification::send($dept_students, new NewAnnouncementNotification($event->announcement));
        }else{
            $course_class_students = User::whereHas('student', function ($query) use ($event){
                $query->whereHas('enrollments', function($query2) use ($event){
                    $query2->where('course_class_id',$event->announcement->course_class_id);
                }); 
            })->where('student_id','!=',null)
              ->where('department_id', $event->announcement->department_id)
              ->get();

              Notification::send($course_class_students, new NewAnnouncementNotification($event->announcement));
        }   
    }
}
