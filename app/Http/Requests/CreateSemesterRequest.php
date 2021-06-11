<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Semester;

class CreateSemesterRequest extends AppBaseFormRequest
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
        //return Semester::$rules;

        return [
            'code' => "required|unique:semesters,code,{$this->id}",
            'start_date' => 'required',
            'end_date' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.'
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'Code',
            'start_date' => 'Start Date',
            'end_date' => 'End Date'
        ];
    }
}
