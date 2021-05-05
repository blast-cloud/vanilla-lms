<?php

namespace App\Listeners;

use App\Events\AssignmentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignmentCreatedListener
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
     * @param  AssignmentCreated  $event
     * @return void
     */
    public function handle(AssignmentCreated $event)
    {
        //
    }
}
