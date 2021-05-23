<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ForumResource extends JsonResource
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
            //'id' => $this->id,
            'group_name' => $this->group_name,
            'posting' => $this->posting,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            //'student_id' => $this->student_id,
            'course_class_id' => $this->course_class_id,
            'parent_forum_id' => $this->parent_forum_id,
            'posting_user_id' => $this->posting_user_id
        ];
    }
}
