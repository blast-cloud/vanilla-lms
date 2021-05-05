<?php

namespace App\Listeners;

use App\Events\CourseClassCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseClassCreatedListener
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
     * @param  CourseClassCreated  $event
     * @return void
     */
    public function handle(CourseClassCreated $event)
    {
        //
    }
}
