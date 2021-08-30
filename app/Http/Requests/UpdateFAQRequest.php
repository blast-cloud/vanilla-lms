<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFAQRequest extends FormRequest
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
        $rules = Forum::$rules;
        
        return $rules;
        */

        return [
            'id'    => 'required|numeric|exists:f_a_q_s,id',
            'type'  => 'required',
            'question' => 'required|string',
            'answer'   => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'string'   => 'The :attribute field must be a valid text.',
        ];
    }

    public function attributes()
    {
        return [
            'type' => 'FAQ Type',
        ];
    }
}
