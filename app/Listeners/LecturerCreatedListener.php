<?php

namespace App\Listeners;


use App\Events\LecturerCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $user = new User();
        $user->email = $event->lecturer->email;
        $user->telephone = $event->lecturer->telephone;
        $user->lecturer_id = $event->lecturer->id;
        $user->password = Hash::make('password');
        $user->name = "{$event->lecturer->first_name} {$event->lecturer->last_name}";
        $user->is_platform_admin = false;
        $user->save();
        
        //Send notification email
    }
}
