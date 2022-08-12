<?php

namespace App\Listeners;

use App\Events\LevelDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LevelDeletedListener
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
     * @param  LevelDeleted  $event
     * @return void
     */
    public function handle(LevelDeleted $event)
    {
        //
    }
}
