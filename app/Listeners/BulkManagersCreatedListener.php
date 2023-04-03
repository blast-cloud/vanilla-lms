<?php

namespace App\Listeners;

use App\Events\BulkManagersCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BulkManagersCreatedNotification;

use App\Models\User;
use Hash;

class BulkManagersCreatedListener
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
     * @param  BulkManagersCreated  $event
     * @return void
     */
    public function handle(BulkManagersCreated $event)
    {
        //Create user account
        $password = substr(md5(time()), 0, 8);

        $user = new User();
        $user->email = $event->manager->email;
        $user->telephone = $event->manager->telephone;
        $user->manager_id = $event->manager->id;
        $user->department_id = $event->manager->department_id;
        $user->password = Hash::make($password);
        $user->name = "{$event->manager->first_name} {$event->manager->last_name}";
        $user->is_platform_admin = false;
        $user->save();
        
        //Send notification email
        Notification::send($event->manager, new BulkManagersCreatedNotification($event->manager,$password));
    }
}
