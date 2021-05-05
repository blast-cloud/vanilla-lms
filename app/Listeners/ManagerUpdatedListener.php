<?php

namespace App\Listeners;

use App\Events\ManagerUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        //
    }
}
