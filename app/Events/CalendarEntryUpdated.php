<?php

namespace App\Events;

use App\Models\CalendarEntry;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CalendarEntryUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $calendarEntry;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CalendarEntry $calendarEntry)
    {
        $this->calendarEntry = $calendarEntry;
    }

}
