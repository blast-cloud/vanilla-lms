<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Grade;

class CreateGradeRequest extends AppBaseFormRequest
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
        //return Grade::$rules;

        return [
            'grade_title' => 'required',
            'student_id' => 'required',
            'course_class_id' => 'required',
            'score' => 'required',
            'grade_letter' => 'required'
        ];
    }
}
