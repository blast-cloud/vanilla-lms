<?php

namespace App\Http\Requests\API;

use App\Models\Lecturer;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;

class UpdateLecturerAPIRequest extends AppBaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /*
        $rules = Lecturer::$rules;
        
        return $rules;
        */
        return [
            'id' => 'required|numeric|exists:lecturers,id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => "required|email|max:100|unique:lecturers,email,{$this->id}",
            'telephone' => "required|digits:11|unique:lecturers,telephone,{$this->id}"
        ];
    }
}
