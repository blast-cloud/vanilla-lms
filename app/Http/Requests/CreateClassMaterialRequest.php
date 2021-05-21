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
            'assignment_number' => 'required_if:type,class-assignments',
            'due_date' => 'required_if:type,class-assignments',
            'lecture_number' => 'required_if:type,lecture-classes',
            'reference_material_url' => 'nullable|url'
        ];
    }

    public function messages()
    {
        return [
            'lecture_number.required_if' => 'The :attribute field is required.',
            'assignment_number.required_if' => 'The :attribute field is required.',
            'due_date.required_if' => 'The :attribute field is required.',
            'reference_material_url.url' => 'The :attribute Must Start with http://'
        ];
    }

    public function attributes()
    {
        return [
            'lecture_number' => 'Lecture Number',
            'title' => 'Title',
            'description' => 'Description',
            'reference_material_url' => 'Reference Material URL'
        ];
    }
}
