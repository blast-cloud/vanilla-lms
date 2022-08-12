<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseClassResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'email_address' => $this->email_address,
            'telephone' => $this->telephone,
            'location' => $this->location,
            'monday_time' => $this->monday_time,
            'tuesday_time' => $this->tuesday_time,
            'wednesday_time' => $this->wednesday_time,
            'thursday_time' => $this->thursday_time,
            'friday_time' => $this->friday_time,
            'saturday_time' => $this->saturday_time,
            'sunday_time' => $this->sunday_time,
            'credit_hours' => $this->credit_hours,
            'next_lecture_date' => $this->next_lecture_date,
            'next_exam_date' => $this->next_exam_date,
            'outline' => $this->outline,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'course_id' => $this->course_id,
            'semester_id' => $this->semester_id,
            'department_id' => $this->department_id,
            'lecturer_id' => $this->lecturer_id,
            'level' => $this->level,
            'lecturer' => $this->lecturer
        ];
    }
}
