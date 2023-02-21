<?php

namespace App\Http\Requests;

use App\Http\Requests\AppBaseFormRequest;

class CreateSemesterMaxCreditLoadRequest extends AppBaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'level' => 'required',
            'semester_code' => 'required',
            'max_credit_load' => 'required'
        ];
    }
}
