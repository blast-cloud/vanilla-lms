<?php

namespace App\Http\Requests\API;

use App\Models\Submission;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;

class UpdateSubmissionAPIRequest extends AppBaseFormRequest
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
        $rules = Submission::$rules;
        
        return $rules;
        */
        return [
            'title' => 'required'
        ];
    }
}
