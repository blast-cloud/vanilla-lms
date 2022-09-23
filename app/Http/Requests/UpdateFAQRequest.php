<?php

namespace App\Http\Requests;

//use Illuminate\Foundation\Http\FormRequest;
use App\Models\FAQ;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;

class UpdateFAQRequest extends AppBaseFormRequest
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
            'id'    => 'required|numeric|exists:faqs,id',
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
