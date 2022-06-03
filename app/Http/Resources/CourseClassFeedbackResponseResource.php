<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseClassFeedbackResponseResource extends JsonResource
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
            'assignments_rating_point' => $this->assignments_rating_point,
            'clarification_rating_point' => $this->clarification_rating_point,
            'examination_rating_point' => $this->examination_rating_point,
            'teaching_rating_point' => $this->teaching_rating_point,
            'course_class_feedback_id' => $this->course_class_feedback_id,
            'course_class_id' => $this->course_class_id,
            'student_id' => $this->student_id,
            'lecturer_id' => $this->lecturer_id,
            'department_id' => $this->department_id,
            'semester_id' => $this->semester_id
        ];
    }
}
