<?php

namespace App\Http\Requests\API;

use App\Models\Enrollment;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;

class UpdateEnrollmentAPIRequest extends AppBaseFormRequest
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
            'id' => 'required|numeric|exists:enrollments,id',
            'student_id' => 'required',
            'course_class_id' => 'required',
            'department_id' => 'required'
        ];
    }

    public function attributes(){
        return [
            'semester_id' => 'semester',
            'course_class_id' => 'course',
            'department_id' => 'department'

        ];
        
    }
}
