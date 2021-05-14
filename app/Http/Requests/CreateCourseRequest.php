<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Course;
use Illuminate\Http\Request;

class CreateCourseRequest extends FormRequest
{

    public $txt_course_primary_id = null;
    public $code = null;
    public $name= null;
    public function __construct(Request $request) {
        $this->txt_course_primary_id = $request->txt_course_primary_id;
        $this->code = $request->code;
        $this->name = $request->name;
    }
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
        return Course::$rules;
    }

    public function codeAlreadyExist(){

        return Course::where('id', '<>', $this->txt_course_primary_id)->where('code', $this->code)->get();
    }

    public function nameAlreadyExist(){

        return Course::where('id', '<>', $this->txt_course_primary_id)->where('name', $this->name)->get();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->code != null && count($this->codeAlreadyExist()) != 0) {
                $validator->errors()->add('code', 'The Course Code Already Exist');
            }
        });

        $validator->after(function ($validator) {
            if ($this->name != null && count($this->nameAlreadyExist()) != 0) {
                $validator->errors()->add('name', 'The Course Name Already Exist');
            }
        });

    }
}
