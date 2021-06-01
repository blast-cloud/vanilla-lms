<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Student;

class UpdateStudentRequest extends AppBaseFormRequest
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
        $rules = Student::$rules;
        
        return $rules;
        */

        return [
            'id' => 'required|numeric|exists:students,id',
            'matriculation_number' => "sometimes|required|max:191|unique:students,matriculation_number,{$this->id}",
            'first_name' => 'sometimes|required|string|max:100',
            'last_name' => 'sometimes|required|string|max:100',
            'email' => "sometimes|required|email|max:100|unique:students,email,{$this->id}",
            'telephone' => "sometimes|required|digits:11|unique:students,telephone,{$this->id}"
        ];
    }
}
