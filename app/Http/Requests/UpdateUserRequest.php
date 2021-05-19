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
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => "required|email|max:100|unique:users,email,{$this->id}",
            'telephone' => "required|digits:11|unique:users,telephone,{$this->id}",
            'matriculation_number' => "nullable|unique:students,matriculation_number,{$this->student_id}"
        ];
    }
}
