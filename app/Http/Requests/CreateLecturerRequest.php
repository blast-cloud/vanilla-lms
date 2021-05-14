<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class CreateLecturerRequest extends FormRequest
{
    public $txt_lecturer_primary_id = null;
    public $email = null;
    public $telephone = null;
    public function __construct(Request $request) {
        $this->txt_lecturer_primary_id = $request->txt_lecturer_primary_id;
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
        return Lecturer::$rules;
    }

    public function emailAlreadyExist(){

        return Lecturer::where('id', '<>', $this->txt_lecturer_primary_id)->where('email', $this->email)->get();
    }


    public function telephoneAlreadyExist(){

        return Lecturer::where('id', '<>', $this->txt_lecturer_primary_id)->where('telephone', $this->telephone)->get();
    }
  

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->email != null && count($this->emailAlreadyExist()) != 0) {
                $validator->errors()->add('email', 'The Email has already been taken');
            }
        });

        $validator->after(function ($validator) {
            if ($this->telephone != null && count($this->telephoneAlreadyExist()) != 0) {
                $validator->errors()->add('telephone', 'The Telephone number has already been taken');
            }
        });
    }
}
