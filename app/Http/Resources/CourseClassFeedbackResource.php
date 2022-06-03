<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseClassFeedbackResource extends JsonResource
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
            'note' => $this->note,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'department_id' => $this->department_id,
            'course_class_id' => $this->course_class_id,
            'creator_user_id' => $this->creator_user_id
        ];
    }
}
