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

        return [
            'id' => 'required|numeric|exists:course_classes,id',
            'code' => 'required',
            'name' => 'required',
            'credit_hours' => 'required',
            'course_id' => 'required',
            'lecturer_id' => 'required',
        ];
    }
}
