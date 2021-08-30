<?php

namespace App\Listeners;

use App\Events\FAQDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FAQDeletedListener
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
     * @param  FAQDeleted  $event
     * @return void
     */
    public function handle(FAQDeleted $event)
    {
        //
    }
}
