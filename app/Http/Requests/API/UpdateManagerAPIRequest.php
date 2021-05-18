<?php

namespace App\Http\Requests\API;

use App\Models\Manager;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;

class UpdateManagerAPIRequest extends AppBaseFormRequest
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
        $rules = Manager::$rules;
        
        return $rules;
        */
        return [
            'id' => 'required|numeric',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => "required|email|max:100|unique:managers,email,{$this->id}",
            'telephone' => "required|digits:11|unique:managers,telephone,{$this->id}"
        ];
    }
}
