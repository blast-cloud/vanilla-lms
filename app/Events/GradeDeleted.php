<?php

namespace App\Events;

use App\Models\Grade;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GradeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $grade;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Grade $grade)
    {
        $this->grade = $grade;
    }

}
