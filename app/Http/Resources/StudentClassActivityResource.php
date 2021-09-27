<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentClassActivityResource extends JsonResource
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
            'type' => $this->student_id,
            'class_id' => $this->class_id,
            'class_material_id' => $this->class_material_id,
            'clicked' => $this->clicked,
            'downloaded' => $this->downloaded,
        ];
    }
}
