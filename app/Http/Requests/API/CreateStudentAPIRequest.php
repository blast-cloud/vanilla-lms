<?php

namespace App\Http\Requests\API;

use App\Models\Student;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;


class CreateStudentAPIRequest extends AppBaseFormRequest
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
        // return Student::$rules;
        return [
            'matriculation_number' => "required|max:191|unique:students,matriculation_number",
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => "required|email|max:100|unique:students,email",
            'telephone' => "required|digits:11|unique:students,telephone",
            'sex' => 'required',
            'level' => 'required|exists:levels,level'
        ];
    }

}
