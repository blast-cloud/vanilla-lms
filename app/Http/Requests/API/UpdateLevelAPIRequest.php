<?php

namespace App\Http\Requests;

class UpdateLevelAPIRequest extends AppBaseFormRequest
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
        //return Course::$rules;

       
        return [
            'name' => "required|unique:levels,name,{$this->id},id",
            'level' => "required|numeric|unique:levels,level,{$this->id},id",
        ];
    }

    public function messages()
    {

        return [
            'name.unique' => 'Level name aready exist',
        ];
    }
}
