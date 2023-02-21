<?php

namespace App\Http\Requests\API;

use App\Http\Requests\AppBaseFormRequest;


class UpdateSemesterMaxCreditLoadAPIRequest extends AppBaseFormRequest
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
