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
        $container = [];
        $loop_limit = 10;
        $loop_begin = intval(date('Y') + 1);
        for ($initial = 0; $initial < $loop_limit; $initial++){
            $neededSession = strval($loop_begin - 1) . "/$loop_begin";
            array_push($container, $neededSession);
            $loop_begin -= 1;
        }
        return [
            'academic_session' => "required|in:". implode($container, ','),
            'code' => "required|string|in:". implode(['First Semester','Second Semester'], ','),
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'unique_code' => 'required|unique:semesters,unique_code|min:11|max:11',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'unique_code.unique' => 'The semester data provided already exist.',
            'unique_code.required' => 'ERROR: PLEASE PROVIDE VALID DATA TO COMPLETE THIS PROCESS.',  
            'unique_code.min' => 'ERROR: PLEASE PROVIDE VALID DATA TO COMPLETE THIS PROCESS.',  
            'unique_code.max' => 'ERROR: PLEASE PROVIDE VALID DATA TO COMPLETE THIS PROCESS.'  
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'Semester Code',
            'academic_session' => 'Academic Session',
            'start_date' => 'Start Date',
            'end_date' => 'End Date'
        ];
    }
}
