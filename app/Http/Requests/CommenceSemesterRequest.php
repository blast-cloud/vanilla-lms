<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Semester;

class CommenceSemesterRequest extends AppBaseFormRequest
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
        return [
            'is_current' => "required|exists:semesters,id",
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
            'is_current' => 'Semester to Commence'
        ];
    }
}
