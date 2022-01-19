<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionResource extends JsonResource
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
            'upload_file_path' => $this->upload_file_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'student_id' => $this->student_id,
            'course_class_id' => $this->course_class_id,
            'class_material_id' => $this->class_material_id,
            'comment' => $this->comment
        ];
    }
}
