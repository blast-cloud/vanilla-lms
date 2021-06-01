<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Manager;

class UpdateManagerRequest extends AppBaseFormRequest
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
            'id' => 'required|numeric|exists:managers,id',
            'first_name' => 'sometimes|required',
            'last_name' => 'sometimes|required',
            'email' => "sometimes|required|email|max:100|unique:managers,email,{$this->id}",
            'telephone' => "sometimes|required|digits:11|unique:managers,telephone,{$this->id}"
        ];
    }
}
