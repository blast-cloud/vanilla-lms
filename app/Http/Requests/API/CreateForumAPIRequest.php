<?php

namespace App\Http\Requests\API;

use App\Models\Forum;
use InfyOm\Generator\Request\APIRequest;

class CreateForumAPIRequest extends APIRequest
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
        return Forum::$rules;
    }
}
