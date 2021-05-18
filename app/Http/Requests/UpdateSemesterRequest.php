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
        /*
        $rules = Semester::$rules;
        
        return $rules;
        */

        return [
            'id' => 'required|numeric',
            'code' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ];
    }
}
