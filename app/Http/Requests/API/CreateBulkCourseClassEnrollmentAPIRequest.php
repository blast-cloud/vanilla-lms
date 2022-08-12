<?php

namespace App\Http\Requests\API;

use App\Models\Enrollment;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;

class CreateBulkCourseClassEnrollmentAPIRequest extends AppBaseFormRequest
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
        $rules = Enrollment::$rules;
        
        return $rules;
        */

        return [
            'course_class_id' => 'required|exists:course_classes,id',
            'semester_id' => 'required|exists:semesters,id',
            'department_id' => 'required|exists:departments,id',
            'level' => 'required|exists:levels,level'
        ];
    }

    public function attributes(){
        return [
            'semester_id' => 'semester',
            'course_class_id' => 'course class',
            'department_id' => 'department',
            'level' => 'level'

        ];
        
    }
    
    public function messages(){

        return [
            'semester_id.required' => 'No active semester found' 
        ];
    }
}
