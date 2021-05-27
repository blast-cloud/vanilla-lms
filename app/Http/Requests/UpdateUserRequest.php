<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\Student;

class UpdateUserRequest extends AppBaseFormRequest
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
        $rules = Manager::$rules;
        
        return $rules;
        */

        return [
            'email'=>"required|email|unique:users,email,{$this->id}",
            'telephone'=>"required|numeric|digits:11|unique:users,telephone,{$this->id}",
            // 'password1'=>'nullable|string|min:8|confirmed|regex:/^(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'first_name' =>'required|string|max:50',
            'department_id' =>'required|string|max:50',
            'last_name' =>'required|string|max:50',
            'matriculation_number' =>"required_if:account_type,student|max:20|unique:students,matriculation_number,{$this->student_id}",
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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'department_id' => 'Department',
            'telephone' => 'Phone Number',
            'email' => 'Email Address',
            'matriculation_number' => 'Matric Number'
        ];
    }
}
