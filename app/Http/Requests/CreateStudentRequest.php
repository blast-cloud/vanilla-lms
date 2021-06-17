<?php

namespace App\Http\Requests;

use App\Models\Student;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;



class CreateStudentRequest extends AppBaseFormRequest
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
        //return Student::$rules;

        return [
            'matriculation_number' => "required|max:191|unique:students,matriculation_number",
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => "required|email|max:100|unique:students,email",
            'telephone' => "required|digits:11|unique:students,telephone"
        ];
    }


    // protected function failedValidation(Validator $validator)
    // {
    //     $errors = (new ValidationException($validator))->errors();

    //     // if ($this->expectsJson()) {
    //     //     throw new HttpResponseException(
    //     //         response()->json(['errors' => $errors], 200)
    //     //     );
    //     // }else{
    //     //     return redirect()->back()->withErrors($validator)->withInput();
    //     // }



    // }


}
