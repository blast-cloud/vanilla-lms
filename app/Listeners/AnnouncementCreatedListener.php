<?php

namespace App\Listeners;

use App\Events\AnnouncementCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AnnouncementCreatedListener
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
     * @param  AnnouncementCreated  $event
     * @return void
     */
    public function handle(AnnouncementCreated $event)
    {
        //
    }
}
