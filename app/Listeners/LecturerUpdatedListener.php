<?php

namespace App\Listeners;

use App\Events\LecturerUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LecturerUpdatedListener
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
     * @param  LecturerUpdated  $event
     * @return void
     */
    public function handle(LecturerUpdated $event)
    {
        //
    }
}
