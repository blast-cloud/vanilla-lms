<?php

namespace App\Listeners;

use App\Events\StudentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\User;
use Hash;

class StudentCreatedListener
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
     * @param  StudentCreated  $event
     * @return void
     */
    public function handle(StudentCreated $event)
    {
        //Create user account
        $user = new User();
        $user->email = $event->student->email;
        $user->telephone = $event->student->telephone;
        $user->student_id = $event->student->id;
        $user->password = Hash::make('password');
        $user->name = "{$event->student->first_name} {$event->student->last_name}";
        $user->is_platform_admin = false;
        $user->save();
        
        //Send notification email
    }
}
