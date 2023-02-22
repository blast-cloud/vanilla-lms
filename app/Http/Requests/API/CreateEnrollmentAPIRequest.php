<?php

namespace App\Http\Requests\API;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Department;
use App\Models\Semester;
use App\Models\CourseClass;
use App\Models\SemesterMaxCreditLoad;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;


class CreateEnrollmentAPIRequest extends AppBaseFormRequest
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
            'course_class_id' => 'required',
            'semester_id' => 'required',
            'department_id' => 'required',
            'level' => 'required'
        ];
    }

    public function enrollment_exist(){
        $request = request();
        return Enrollment::where('student_id', $request->student_id)
                         ->where('course_class_id', $request->course_class_id)
                         ->where('department_id', $request->department_id)->get();
    }

    public function maximum_credit_loads(){
        $request = request();
        $credit_load = 0;
        $total_credit_loads = 0;

        $student = Student::find($request->student_id);
        $semester = Semester::find($request->semester_id);
        $course_class = CourseClass::find($request->course_class_id);
        
        $enrollments = Enrollment::where('student_id', $student->id)->where('semester_id',$semester->id)->get();

        foreach($enrollments as $enrollment){
            $credit_load = $enrollment->courseClass->credit_hours;

            $total_credit_loads+=$credit_load;
        }
        $max_credit_load = SemesterMaxCreditLoad::where('level',$student->level)
                            ->where('semester_code', $semester->code)
                            ->where('department_id', $student->department_id)
                            ->first();
        if($max_credit_load != null){
            if(($total_credit_loads <= $max_credit_load->max_credit_load) && ($total_credit_loads + $course_class->course->credit_hours <= $max_credit_load->max_credit_load)){
                return ['max_credit_load' => $max_credit_load->max_credit_load, 'message' => true];
            }
            return ['max_credit_load' => $max_credit_load->max_credit_load, 'message' => false];
        }
        return null;
    }

    public function withValidator($validator) : void
    {
        $max_credit_loads = $this->maximum_credit_loads();

        $validator->after(function ($validator) {
            if (count($this->enrollment_exist()) != 0) {
                $validator->errors()->add('enrollment_exist', 'This Student is already enrolled for this Class');
            }
        });

        $validator->after(function($validator) use ($max_credit_loads){
            if($max_credit_loads != null){
                if(($max_credit_loads['message'] == false)){
                    $validator->errors()->add('maximum_credit_loads', 'The maximum allowed credit load for this semester is '.$max_credit_loads['max_credit_load']);
                }
            }
        });
    }

    public function attributes(){
        return [
            'semester_id' => 'semester',
            'course_class_id' => 'course class',
            'department_id' => 'department'

        ];
        
    }

    public function messages(){
        return [
            'semester_id.required' => 'No active semester found or selected'
        ];
    } 
}
