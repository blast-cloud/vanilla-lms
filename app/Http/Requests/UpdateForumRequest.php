<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Forum;

class UpdateForumRequest extends AppBaseFormRequest
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
            'group_name' => 'required'
        ];
    }
}
