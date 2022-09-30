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
    public function rules()
    {
        $level_val = intval(request()->level);
        $nearest_number = (!empty($level_val) && $level_val >= 100) ? intval(ceil($level_val / 100) * 100) : null;
        $returned_validation = '';

        if ($nearest_number != null) {
            $possible_levels_in_hundreds = [];
            
            for ($i=100; $i<=$nearest_number ; $i+=100) { 
                array_push($possible_levels_in_hundreds, $i);
            }
            $returned_validation = "|in:". implode($possible_levels_in_hundreds, ',');
        }
           
        return [
            'name' => "required|unique:levels,name,{$this->id},id",
            'level' => "required|numeric|unique:levels,level,{$this->id},id|min:100$returned_validation",
        ];
    }

    public function messages(){

        return [
            'name.unique' => 'Level name aready exist',
            'level.in' => 'Level must be in multiple of hundreds (100\'s)',
        ];
    }
}
