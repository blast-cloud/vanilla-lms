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
            'get_end_date' => "required|date|after:today",
        ];
    }

    public function messages()
    {
        return [
            'get_end_date.required' => 'PICK-UP A VALID SEMESTER TO PROCEED.',
            'get_end_date.date' => 'PICK-UP A VALID SEMESTER TO PROCEED.',
            'get_end_date.after' => 'Semester selected has an expired END-DATE of ' . date('(D) d-M-Y', strtotime($this->get_end_date)) . '. (i.e: END-DATE is considered invalid!)',
            'required' => 'The :attribute field is required.',
        ];
    }

    public function attributes()
    {
        return [
            'is_current' => 'Semester to Commence'
        ];
    }
}
