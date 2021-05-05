<?php

namespace App\Events;

use App\Models\ClassMaterial;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClassMaterialUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $classMaterial;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ClassMaterial $classMaterial)
    {
        $this->classMaterial = $classMaterial;
    }

}
