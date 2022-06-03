<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CourseClassFeedbackResponse;

class CreateCourseClassFeedbackResponseRequest extends AppBaseFormRequest
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
        return [
           'assignments_rating_point' => 'required',
           'clarification_rating_point' => 'required',
           'examination_rating_point' => 'required',
           'teaching_rating_point' => 'required'
        ];
    }
}
