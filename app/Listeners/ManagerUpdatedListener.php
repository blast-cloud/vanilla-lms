<?php

namespace App\Listeners;

use App\Events\ManagerUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;


class ManagerUpdatedListener
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
     * @param  ManagerUpdated  $event
     * @return void
     */
    public function handle(ManagerUpdated $event)
    {
        //Update user Record
        $user = User::where('email', $event->manager->email)->first();
        $user->email = $event->manager->email;
        $user->telephone = $event->manager->telephone;
        $user->lecturer_id = $event->manager->id;
        $user->department_id = $event->manager->department_id;
        $user->name = "{$event->manager->first_name} {$event->manager->last_name}";
        $user->is_platform_admin = false;
        $user->save();
    }
}
