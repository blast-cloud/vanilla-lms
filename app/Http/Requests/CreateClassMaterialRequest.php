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
        $remaining_pct_grade = $this->input('remaining_pct_grade');
        $today = date('Y-m-d');
        return [
            'type' => 'required',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:100000',
            'examination_number' => 'required_if:type,class-examinations',
            'assignment_number' => 'required_if:type,class-assignments',
            'file' => 'required_if:type,reading-materials|mimes:pdf,doc,docx,zip,xls,xlsx,xlsb,xlsm',
            'due_date' => 'required_if:type,class-assignments|date|after_or_equal:'.$today,
            'lecture_number' => 'required_if:type,lecture-classes|unique:class_materials|gt:0',
            'reference_material_url' => 'nullable|url',
            'grade_max_points' => 'required_if:type,class-examinations|numeric|min:0|max:100',
            'grade_contribution_pct' => 'required_if:type,class-examinations|numeric|min:0|max:'.$remaining_pct_grade,
            'grade_contribution_notes' => 'nullable|string|max:300',
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
            'file.required_if' => 'The :attribute field is required.',
            'grade_max_points.required_if' => 'The :attribute field is required.',
            'grade_contribution_pct.required_if' => 'The :attribute field is required.',
            'due_date.after_or_equal' => 'The :attribute field cannot be set to a past date',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'lecture_number' => 'Lecture Number',
            'examination_number' => 'Examination Number',
            'reference_material_url' => 'Reference Material URL',
            'grade_max_points' => 'Maximum Points towards Grade',
            'grade_contribution_pct' => 'Percent Contribution to Grade',
            'grade_contribution_notes' => 'Grade Notes',
        ];
    }

}
