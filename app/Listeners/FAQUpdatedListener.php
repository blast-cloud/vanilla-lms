<?php

namespace App\Listeners;

use App\Events\FAQUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FAQUpdatedListener
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
     * @param  FAQUpdated  $event
     * @return void
     */
    public function handle(FAQUpdated $event)
    {
        //
    }
}
