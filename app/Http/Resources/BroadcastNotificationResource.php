<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BroadcastNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'semester_id' => $this->semester_id,
            'title' => $this->title,
            'message' => $this->message,
            'admin_receives' => $this->admin_receives,
            'managers_receives' => $this->managers_receives,
            'lecturers_receives' => $this->lecturers_receives,
            'students_receives' => $this->students_receives,
            'broadcast_status' => $this->broadcast_status,
            'scheduled_date' => $this->scheduled_date,
            'scheduled_time' => $this->scheduled_time,
        ];
    }
}
