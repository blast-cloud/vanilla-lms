<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Course;

class UpdateCourseRequest extends AppBaseFormRequest
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
        $rules = Course::$rules;
        
        return $rules;
        */

        return [
            'id' => 'required|numeric|exists:courses,id',
            'code' => "required|max:191|unique:courses,code,{$this->id}",
            'name' => "required|max:191|unique:courses,name,{$this->id}",
            'description' => 'required',
            'credit_hours' => 'required'
        ];
    }
}
