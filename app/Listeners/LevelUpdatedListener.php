<?php

namespace App\Listeners;

use App\Events\LevelUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LevelUpdatedListener
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
     * @param  LevelUpdated  $event
     * @return void
     */
    public function handle(LevelUpdated $event)
    {
        //
    }
}
