<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassMaterialResource extends JsonResource
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
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'lecture_number' => $this->lecture_number,
            'assignment_number' => $this->assignment_number,
            'due_date' => $this->due_date,
            'blackboard_meeting_id' => $this->blackboard_meeting_id,
            'blackboard_meeting_status' => $this->blackboard_meeting_status,
            'upload_file_path' => $this->upload_file_path,
            'upload_file_type' => $this->upload_file_type,
            'reference_material_url' => $this->reference_material_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'course_class_id' => $this->course_class_id
        ];
    }
}
