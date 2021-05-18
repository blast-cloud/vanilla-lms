<?php

namespace App\Http\Requests\API;

use App\Models\Grade;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;

class UpdateGradeAPIRequest extends AppBaseFormRequest
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
        $rules = Grade::$rules;
        
        return $rules;
        */
        return [
            'grade_title' => 'required',
            'student_id' => 'required',
            'course_class_id' => 'required',
            'score' => 'required',
            'grade_letter' => 'required'
        ];
    }
}
