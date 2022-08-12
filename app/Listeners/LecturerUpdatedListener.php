<?php

namespace App\Listeners;

use App\Events\LecturerUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;

class LecturerUpdatedListener
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
     * @param  LecturerUpdated  $event
     * @return void
     */
    public function handle(LecturerUpdated $event)
    {
        //Update user Record
        $user = User::where('lecturer_id', $event->lecturer->id)->first();
        $user->email = $event->lecturer->email;
        $user->telephone = $event->lecturer->telephone;
        $user->lecturer_id = $event->lecturer->id;
        $user->student_id = null;
        $user->sex = $event->lecturer->sex;
        $user->department_id = $event->lecturer->department_id;
        $user->name = "{$event->lecturer->first_name} {$event->lecturer->last_name}";
        $user->is_platform_admin = false;
        $user->save();
    }
}
