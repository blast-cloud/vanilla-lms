<?php

namespace App\Listeners;

use App\Events\BulkStudentsCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BulkStudentsCreatedNotification;

use App\Models\User;
use Hash;

class BulkStudentsCreatedListener
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
     * @param  BulkStudentsCreated  $event
     * @return void
     */
    public function handle(BulkStudentsCreated $event)
    {
        //Create user account
        $password = substr(md5(time()), 0, 8);

        $user = new User();
        $user->email = $event->student->email;
        $user->telephone = $event->student->telephone;
        $user->student_id = $event->student->id;
        $user->department_id = $event->student->department_id;
        $user->password = Hash::make($password);
        $user->name = "{$event->student->first_name} {$event->student->last_name}";
        $user->is_platform_admin = false;
        $user->sex = $event->student->sex;
        $user->save();
        
        //Send notification email
        Notification::send($event->student, new BulkStudentsCreatedNotification($event->student,$password));
    }
}
