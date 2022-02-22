<?php

namespace App\Listeners;


use App\Events\LecturerCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LecturerCreatedNotification;

use App\Models\User;
use Hash;

class LecturerCreatedListener
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
     * @param  LecturerCreated  $event
     * @return void
     */
    public function handle(LecturerCreated $event)
    {
        //Create user account
        $password = substr(md5(time()), 0, 8);

        $user = new User();
        $user->email = $event->lecturer->email;
        $user->telephone = $event->lecturer->telephone;
        $user->lecturer_id = $event->lecturer->id;
        $user->department_id = $event->lecturer->department_id;
        $user->password = Hash::make($password);
        $user->name = "{$event->lecturer->first_name} {$event->lecturer->last_name}";
        $user->is_platform_admin = false;
        $user->save();
        
        //Send notification email
        Notification::send($event->lecturer, new LecturerCreatedNotification($event->lecturer,$password));
    }
}
