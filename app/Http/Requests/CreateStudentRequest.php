<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class CreateStudentRequest extends FormRequest
{

    public $txt_student_primary_id = null;
    public $matriculation_number = null;
    public $email = null;
    public $telephone = null;
    public function __construct(Request $request) {
        $this->txt_student_primary_id = $request->txt_student_primary_id;
        $this->matriculation_number = $request->matriculation_number;
        $this->email = $request->email;
        $this->telephone = $request->telephone;
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
        return Student::$rules;
    }

    public function matricNumberAlreadyExist(){

        return Student::where('id', '<>', $this->txt_student_primary_id)->where('matriculation_number', $this->matriculation_number)->get();
    }

    public function emailAlreadyExist(){

        return Student::where('id', '<>', $this->txt_student_primary_id)->where('email', $this->email)->get();
    }


    public function telephoneAlreadyExist(){

        return Student::where('id', '<>', $this->txt_student_primary_id)->where('telephone', $this->telephone)->get();
    }
  

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->email != null && count($this->emailAlreadyExist()) != 0) {
                $validator->errors()->add('email', 'The Email number has already been taken');
            }
        });

        $validator->after(function ($validator) {
            if ($this->matriculation_number != null && count($this->matricNumberAlreadyExist()) != 0) {
                $validator->errors()->add('matriculation_number', 'The Matriculation number has already been taken');
            }
        });

        $validator->after(function ($validator) {
            if ($this->telephone != null && count($this->telephoneAlreadyExist()) != 0) {
                $validator->errors()->add('telephone', 'The Telephone number has already been taken');
            }
        });
    }
}
