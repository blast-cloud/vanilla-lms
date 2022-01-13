<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CourseClass;

class UpdateCourseClassRequest extends AppBaseFormRequest
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
        $today = date('Y/m/d');
        $todayDateTime = date('Y-m-d g:i A');
        return [
            'id' => 'required|numeric|exists:course_classes,id',
            'code' => 'sometimes|required',
            'name' => 'sometimes|required',
            'credit_hours' => 'sometimes|required',
            'course_id' => 'sometimes|required',
            'lecturer_id' => 'sometimes|required',
            'semester_id' => 'sometimes|required',
            'next_lecture_date' => 'sometimes|required|date|after_or_equal:'.$today,
            'next_exam_date' => 'sometimes|required|date|after_or_equal:'.$today,
            'lecture_date' => 'required_if:type,lecture_classes|date|after_or_equal:'.$todayDateTime,
        ];
    }

    public function course_class_exist(){
        return CourseClass::where('code', $this->code)->where('lecturer_id', $this->lecturer_id)->where('semester_id', $this->lecturer_id)->where('id','<>', $this->id)->get();
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
}
