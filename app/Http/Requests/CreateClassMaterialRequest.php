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
            'description' => 'required_without_all:file,reference_material_url',
            'file' => 'required_if:type,reading-materials|mimes:pdf,doc,docx,zip,xls,xlsx,xlsb,xlsm',
            'due_date' => 'required_if:type,class-assignments|date|after_or_equal:'.$today,
            'assignment_number' => 'required_if:type,class-assignments|gt:0|unique:class_materials,assignment_number,NULL,id,course_class_id,'.$this->get('course_class_id'),
            'lecture_number' => 'required_if:type,class-lectures|gt:0|unique:class_materials,lecture_number,NULL,id,course_class_id,'.$this->get('course_class_id'),
            'examination_number' => 'required_if:type,class-examinations|gt:0|unique:class_materials,examination_number,NULL,id,course_class_id,'.$this->get('course_class_id'),
            'reference_material_url' => 'nullable|url',
            'grade_max_points' => 'required_if:type,class-examinations|numeric|min:0|max:100',
            'grade_contribution_pct' => 'required_if:type,class-examinations|numeric|min:0|max:'.$remaining_pct_grade,
            'grade_contribution_notes' => 'nullable|string|max:300',
            'lecture_date' => 'required_if:type,lecture_classes|date|after:today',
            'lecture_time' => 'required_if:type,lecture_classes|date_format:h:i A',
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
            'grade_contribution_pct.max' => 'The :attribute field cannot be zero or greater than the remaining available percentage grade contribution',
            'lecture_time.date_format' => 'The :attribute field should be a time in 12 hours format'
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
