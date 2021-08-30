<?php

namespace App\Listeners;

use App\Events\FAQCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FAQCreatedListener
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
     * @param  FAQCreated  $event
     * @return void
     */
    public function handle(FAQCreated $event)
    {
        //
    }
}
