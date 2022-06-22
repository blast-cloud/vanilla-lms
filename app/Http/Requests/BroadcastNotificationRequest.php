<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Semester;

class BroadcastNotificationRequest extends AppBaseFormRequest
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
        if ($this->at_least_one_checked == '0') {
            $isChecked_error = "required|in:1";
        } else if ($this->at_least_one_checked == '1'){
            $isChecked_error = "";
        }
        return [
            'title' => 'required|string|min:10|max:191',
            'message' => 'required|string|min:10',
            'at_least_one_checked' => "$isChecked_error",
        ];
    }

    public function messages()
    {
        return [
            'at_least_one_checked.in' => 'You must proceed by selecting at least one or more receipient(s)',
        ];
    }
}
