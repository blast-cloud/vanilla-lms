<?php

namespace App\Http\Requests\API;

use App\Models\Forum;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;

class UpdateForumAPIRequest extends AppBaseFormRequest
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
            'id' => 'required|numeric|exists:forums,id',
            'posting' => 'required',
            'group_name' => 'sometimes|required'
        ];
    }
}
