<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Grade;

class UpdateGradeRequest extends AppBaseFormRequest
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
            'id' => 'required|numeric|exists:grades,id',
            'grade_title' => 'sometimes|required',
            'student_id' => 'sometimes|required',
            'course_class_id' => 'sometimes|required',
            'score' => 'sometimes|required',
            'grade_letter' => 'sometimes|required'
        ];
    }
}
