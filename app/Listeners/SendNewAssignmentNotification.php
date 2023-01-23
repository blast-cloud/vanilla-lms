<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewAssignmentNotification;
use App\Events\ClassMaterialCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewAssignmentNotification
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
    public function handle(ClassMaterialCreated $event)
    {
        $course_class_students = User::whereHas('student', function ($query) use ($event){
            $query->whereHas('enrollments', function($query2) use ($event){
                $query2->where('course_class_id',$event->classMaterial->course_class_id);
            }); 
        })->where('student_id','!=',null)
          ->where('department_id', $event->classMaterial->department_id)
          ->get();

        Notification::send($course_class_students, new NewAssignmentNotification($event->classMaterial));
    }
}
