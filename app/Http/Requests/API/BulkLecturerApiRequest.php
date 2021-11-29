<?php

namespace App\Http\Requests\API;

use App\Http\Requests\AppBaseFormRequest;

class BulkLecturerApiRequest extends AppBaseFormRequest
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
        return [
            'bulk_staff_file' => 'required|mimes:csv,txt'
        ];
    }
}
