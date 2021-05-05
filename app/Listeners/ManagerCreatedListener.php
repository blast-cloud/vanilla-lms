<?php

namespace App\Listeners;

use App\Events\ManagerCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\User;
use Hash;

class ManagerCreatedListener
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
     * @param  ManagerCreated  $event
     * @return void
     */
    public function handle(ManagerCreated $event)
    {
        //Create user account
        $user = new User();
        $user->email = $event->manager->email;
        $user->telephone = $event->manager->telephone;
        $user->manager_id = $event->manager->id;
        $user->password = Hash::make('password');
        $user->name = "{$event->manager->first_name} {$event->manager->last_name}";
        $user->is_platform_admin = false;
        $user->save();
        
        //Send notification email
    }
}
