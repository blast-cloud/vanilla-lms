<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'key' => $this->key,
            'value' => $this->value,
            'group_name' => $this->group_name,
            'model_type' => $this->model_type,
            'model_value' => $this->model_value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
