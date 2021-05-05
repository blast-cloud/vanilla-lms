<?php

namespace App\Listeners;

use App\Events\AssignmentUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignmentUpdatedListener
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
     * @param  AssignmentUpdated  $event
     * @return void
     */
    public function handle(AssignmentUpdated $event)
    {
        //
    }
}
