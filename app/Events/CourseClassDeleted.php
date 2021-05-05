<?php

namespace App\Events;

use App\Models\CourseClass;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseClassDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $courseClass;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CourseClass $courseClass)
    {
        $this->courseClass = $courseClass;
    }

}
