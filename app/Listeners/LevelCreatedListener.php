<?php

namespace App\Listeners;

use App\Events\LevelCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LevelCreatedListener
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
     * @param  LevelCreated  $event
     * @return void
     */
    public function handle(LevelCreated $event)
    {
        //
    }
}
