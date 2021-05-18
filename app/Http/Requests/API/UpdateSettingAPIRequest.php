<?php

namespace App\Http\Requests\API;

use App\Models\Setting;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;

class UpdateSettingAPIRequest extends AppBaseFormRequest
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
        $rules = Setting::$rules;
        
        return $rules;
        */
        return [
            'key' => 'required',
            'value' => 'nullable',
            'group_name' => 'nullable',
            'model_type' => 'nullable',
            'model_value' => 'nullable'
        ];
    }
}
