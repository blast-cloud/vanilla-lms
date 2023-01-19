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
        $dept_students = User::where('student_id',"!=", null)->where('department_id', $event->classMaterial->department_id)->get();

        Notification::send($dept_students, new NewAssignmentNotification($event->classMaterial));
    }
}
