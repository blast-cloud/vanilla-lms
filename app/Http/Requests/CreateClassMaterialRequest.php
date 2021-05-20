<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ClassMaterial;

class CreateClassMaterialRequest extends AppBaseFormRequest
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
        //return ClassMaterial::$rules;

        return [
            'type' => 'required',
            'title' => 'required',
            'description' => 'required',
            'assignment_number' => 'required_if:type,class_assignments',
            'due_date' => 'required_if:type,class_assignments',
            'lecture_number' => 'required_if:type,lecture-classes'
        ];
    }

    public function messages()
    {
        return [
            'lecture_number.required_if' => 'The :attribute field is required.'
        ];
    }

    public function attributes()
    {
        return [
            'lecture_number' => 'Lecture Number',
            'title' => 'Title',
            'description' => 'Description'
        ];
    }
}
