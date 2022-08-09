<?php

namespace App\Events;

use App\Models\Level;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LevelCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $level;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Level $level)
    {
        $this->level = $level;
    }

}
