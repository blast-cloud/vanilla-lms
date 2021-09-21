<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ClassMaterial;

class UpdateClassMaterialRequest extends AppBaseFormRequest
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
        $rules = ClassMaterial::$rules;
        
        return $rules;
        */
        $remaining_pct_grade = $this->input('remaining_pct_grade');
        $today = date('Y-m-d');
        return [
            'id' => "required|numeric|exists:class_materials,id",
            'type' => 'required',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:100000',
            'examination_number' => 'sometimes|required_if:type,class-examinations',
            'assignment_number' => 'sometimes|required_if:type,class-assignments',
            'due_date' => 'sometimes|required_if:type,class-assignments|date|after_or_equal:'.$today,
            'grade_contribution_pct' => 'required_if:type,class-examinations|numeric|min:0|max:'.$remaining_pct_grade,
            'lecture_number' => "sometimes|required_if:type,lecture-classes|gt:0|unique:class_materials,lecture_number,{$this->id}",
            'reference_material_url' => 'nullable|url'
        ];
    }

    public function messages()
    {
        return [
            'lecture_number.required_if' => 'The :attribute field is required.',
            'assignment_number.required_if' => 'The :attribute field is required.',
            'examination_number.required_if' => 'The :attribute field is required.',
            'due_date.required_if' => 'The :attribute field is required.',
            'reference_material_url.url' => 'The :attribute Must Start with http://',
            'due_date.after_or_equal' => 'The :attribute field cannot be set to a past date',
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
