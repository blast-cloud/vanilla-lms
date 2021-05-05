<?php

namespace App\Events;

use App\Models\Semester;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SemesterCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $semester;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Semester $semester)
    {
        $this->semester = $semester;
    }

}
