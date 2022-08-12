<?php

namespace App\Http\Requests\API;

use App\Models\CourseClass;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;


class CreateCourseClassAPIRequest extends AppBaseFormRequest
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
        // return CourseClass::$rules;
        return [
            'code' => 'required',
            'name' => 'required',
            'credit_hours' => 'required',
            'course_id' => 'required',
            'lecturer_id' => 'required',
            'semester_id' => 'required',
        ];
    }

    public function course_class_exist(){
        return CourseClass::where('code', $this->code)->where('lecturer_id', $this->lecturer_id)->where('semester_id', $this->semester_id)->get();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (count($this->course_class_exist()) != 0) {
                $validator->errors()->add('class_exist', 'This Lecturer is already Assigned to this Course');
            }
        });
    }
    public function attributes()
    {
        return [
            'lecturer_id' => 'Lecturer',
            'semester_id' => 'Semester',
            'course_id' => 'Course'
        ];
    }

    public function messages(){
        return [
            'semester_id.required' => 'No active semester found'
        ];
    }
}
