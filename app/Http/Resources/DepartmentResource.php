<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'website_url' => $this->website_url,
            'email_address' => $this->email_address,
            'contact_phone' => $this->contact_phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
