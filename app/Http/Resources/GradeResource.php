<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
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
            'grade_title' => $this->grade_title,
            'score' => $this->score,
            'grade_letter' => $this->grade_letter,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'student_id' => $this->student_id,
            'course_class_id' => $this->course_class_id,
            'class_material_id' => $this->class_material_id
        ];
    }
}
