<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Semester;

class UpdateSemesterRequest extends AppBaseFormRequest
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
        $container = [];
        $loop_limit = 10;
        $loop_begin = intval(date('Y') + 1);
        for ($initial = 0; $initial < $loop_limit; $initial++){
            $neededSession = strval($loop_begin - 1) . "/$loop_begin";
            array_push($container, $neededSession);
            $loop_begin -= 1;
        }
        return [
            'academic_session' => 'required',
            'code' => "required|string|in:". implode(['First Semester','Second Semester'], ','),
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'unique_code' => 'required|min:11|max:11|unique:semesters,unique_code,' .$this->id,
        ];
    }


    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'unique_code.unique' => 'The semester data provide already exist.',
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
