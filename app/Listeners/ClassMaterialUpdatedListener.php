<?php

namespace App\Listeners;

use App\Events\ClassMaterialUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ClassMaterialUpdatedListener
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
     * @param  ClassMaterialUpdated  $event
     * @return void
     */
    public function handle(ClassMaterialUpdated $event)
    {
        //
    }
}
