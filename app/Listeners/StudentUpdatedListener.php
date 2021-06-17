<?php

namespace App\Listeners;

use App\Events\StudentUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;

class StudentUpdatedListener
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
     * @param  StudentUpdated  $event
     * @return void
     */
    public function handle(StudentUpdated $event)
    {
        //Update user Record
        $user = User::where('email', $event->student->email)->first();
        $user->email = $event->student->email;
        $user->telephone = $event->student->telephone;
        $user->lecturer_id = $event->student->id;
        $user->department_id = $event->student->department_id;
        $user->name = "{$event->student->first_name} {$event->student->last_name}";
        $user->is_platform_admin = false;
        $user->save();
    }
}
