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
            'type' => 'required',
            'title' => 'required|string|max:200',
            'description' => 'required_without_all:upload_file,reference_material_url|string',
            'file' => 'required_if:type,reading-materials|mimes:pdf,doc,docx,zip,xls,xlsx,xlsb,xlsm',
            'due_date' => 'required_if:type,class-assignments|date|after_or_equal:'.$today,
            'assignment_number' => 'required_if:type,class-assignments|gt:0|unique:class_materials,assignment_number,'.$this->get('id').',id,course_class_id,'.$this->get('course_class_id'),
            'lecture_number' => 'required_if:type,class-lectures|gt:0|unique:class_materials,lecture_number,'.$this->get('id').',id,course_class_id,'.$this->get('course_class_id'),
            'examination_number' => 'required_if:type,class-examinations|gt:0|unique:class_materials,examination_number,'.$this->get('id').',id,course_class_id,'.$this->get('course_class_id'),
            'reference_material_url' => 'nullable|url',
            'grade_max_points' => 'required_if:type,class-examinations|numeric|min:0|max:100',
            'grade_contribution_pct' => 'required_if:type,class-examinations|numeric|min:0|max:'.$remaining_pct_grade,
            'grade_contribution_notes' => 'nullable|string|max:300',
            'lecture_date' => 'required_if:type,lecture_classes|date|after_or_equal:today',
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
            'due_date.after_or_equal' => 'The :attribute field cannot be set to a past date',
            'grade_contribution_pct.max' => 'The :attribute field cannot be zero or greater than the available assignable percentage grade contribution',
            'lecture_time.date_format' => 'The :attribute field should be a time in 12 hours format'
        ];
    }

    public function attributes()
    {
        return [
            'lecture_number' => 'Lecture Number',
            'title' => 'Title',
            'description' => 'Description',
            'reference_material_url' => 'Reference Material URL',
            'grade_contribution_pct' => 'Percent Contribution to Grade',
        ];
    }
}
