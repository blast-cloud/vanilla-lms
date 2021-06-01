<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Lecturer;

class UpdateLecturerRequest extends AppBaseFormRequest
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
        $rules = Lecturer::$rules;
        
        return $rules;
        */

        return [
            'id' => 'required|numeric|exists:lecturers,id',
            'first_name' => 'sometimes|required|string|max:100',
            'last_name' => 'sometimes|required|string|max:100',
            'email' => "sometimes|required|email|max:100|unique:lecturers,email,{$this->id}",
            'telephone' => "sometimes|required|digits:11|unique:lecturers,telephone,{$this->id}"
        ];
    }
}
