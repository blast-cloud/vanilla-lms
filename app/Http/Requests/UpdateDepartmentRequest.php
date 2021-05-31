<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Department;

class UpdateDepartmentRequest extends AppBaseFormRequest
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
        $rules = Department::$rules;
        
        return $rules;
        */

        return [
            'id' => 'required|numeric|exists:departments,id',
            'code' => "required|max:191|unique:departments,code,{$this->id}",
            'name' => "required|max:191|unique:departments,name,{$this->id}",
            'website_url' => 'nullable|url',
            'email_address' => "nullable|email|unique:departments,email_address,{$this->id}",
            'contact_phone' => "nullable|numeric|digits:11|unique:departments,contact_phone,{$this->id}",
        ];
    }
}
