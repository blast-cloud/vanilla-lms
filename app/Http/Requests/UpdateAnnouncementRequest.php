<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Announcement;

class UpdateAnnouncementRequest extends AppBaseFormRequest
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
        $rules = Announcement::$rules;
        
        return $rules;
        */

        return [
            'id' => 'required|numeric|exists:announcements,id',
            'title' => 'required',
            'description' => 'required',
        ];
    }
}
