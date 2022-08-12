<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'email' => $this->email,
            'matriculation_number' => $this->matriculation_number,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'sex' => $this->sex,
            'level' => $this->level,
            'telephone' => $this->telephone,
            'picture_file_path' => $this->picture_file_path,
            'profile_external_url' => $this->profile_external_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'department_id' => $this->department_id,
            'has_graduated' => $this->has_graduated
        ];
    }
}
