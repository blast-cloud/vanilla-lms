<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Enrollment;

class CreateEnrollmentRequest extends AppBaseFormRequest
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
        //return Enrollment::$rules;

        return [
            'status' => 'nullable',
            'student_id' => 'required',
            'course_class_id' => 'required'
        ];
    }

    public function enrollment_exist(){
        return Enrollment::where('student_id', $this->student_id)->where('course_class_id', $this->course_class_id)->get();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (count($this->enrollment_exist()) != 0) {
                $validator->errors()->add('enrollment_exist', 'This Student is Already enroll for this Class');
            }
        });
    }
}
