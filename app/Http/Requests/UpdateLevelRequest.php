<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Level;

class UpdateLevelRequest extends AppBaseFormRequest
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
    public function rules() {           
        return [
            'name' => "required|unique:levels,name,{$this->id},id,deleted_at,NULL",
            'level' => "required|numeric|unique:levels,level,{$this->id},id,deleted_at,NULL|min:100",
        ];
    }


    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $level_val = intval(request()->level);

            if( ($level_val > 100) && ($level_val%100 != 0) ) {
                /*inputed level to nearest hundered*/
                $possible_hundreds = intval(ceil($level_val / 100) * 100); 
                $validator->errors()->add('level', 'Level must be a multiple of hundred (i.e: ' . strval($possible_hundreds-100) . ', ' . $possible_hundreds . ', ...)');
            }
        });
    }

    public function messages() {

        return [
            'name.unique' => 'Level name aready exist'
        ];
    }
}
