<?php

namespace App\Http\Requests;

namespace App\Http\Requests\API;

use App\Http\Requests\AppBaseFormRequest;


class ChangeStudentStatusAPIRequest extends AppBaseFormRequest
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
            'id' => 'required|exists:students,id',
            'level' => 'required|exists:levels,level'
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
