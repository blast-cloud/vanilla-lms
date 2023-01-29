<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'announcement_end_date' => $this->announcement_end_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'course_class_id' => $this->course_class_id,
            'department_id' => $this->department_id
        ];
    }
}
