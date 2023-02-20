<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SemesterMaxCreditLoadResource extends JsonResource
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
            'level' => $this->level,
            'semester_code' => $this->semester_code,
            'max_credit_load' => $this->max_credit_load,
            'department_id' => $this->department_id
        ];
    }
}
