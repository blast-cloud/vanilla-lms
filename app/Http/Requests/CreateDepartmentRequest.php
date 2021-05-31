<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Department;

class CreateDepartmentRequest extends AppBaseFormRequest
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
        //return Department::$rules;

        return [
            'code' => 'required|max:191|unique:departments,code',
            'name' => 'required|max:191|unique:departments,name',
            'website_url' => 'nullable|url',
            'email_address' => "nullable|email",
            'contact_phone' => "nullable|numeric|digits:11",
        ];
    }
}
