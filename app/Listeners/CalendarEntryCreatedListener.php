<?php

namespace App\Listeners;

use App\Events\CalendarEntryCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalendarEntryCreatedListener
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
     * @param  CalendarEntryCreated  $event
     * @return void
     */
    public function handle(CalendarEntryCreated $event)
    {
        //
    }
}
