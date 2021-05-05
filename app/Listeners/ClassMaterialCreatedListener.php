<?php

namespace App\Listeners;

use App\Events\ClassMaterialCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ClassMaterialCreatedListener
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
     * @param  ClassMaterialCreated  $event
     * @return void
     */
    public function handle(ClassMaterialCreated $event)
    {
        //
    }
}
