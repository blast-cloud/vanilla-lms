<?php

namespace App\Http\Requests\API;

use App\Models\CourseClass;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;

class UpdateCourseClassAPIRequest extends AppBaseFormRequest
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
        $rules = CourseClass::$rules;
        
        return $rules;
        */
        return [
            'id' => 'required|numeric|exists:course_classes,id',
            'code' => 'required',
            'name' => 'required',
            'credit_hours' => 'required',
            'course_id' => 'required',
            'lecturer_id' => 'required',
        ];
    }

    public function course_class_exist(){
        return CourseClass::where('code', $this->code)->where('lecturer_id', $this->lecturer_id)->where('id','<>', $this->id)->get();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (count($this->course_class_exist()) != 0) {
                $validator->errors()->add('class_exist', 'This Lecturer is already Assigned to this Course');
            }
        });
    }
}
