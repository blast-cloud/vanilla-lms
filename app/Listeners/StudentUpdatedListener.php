<?php

namespace App\Listeners;

use App\Events\StudentUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        //
    }
}
