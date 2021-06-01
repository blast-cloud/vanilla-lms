<?php

namespace App\Http\Requests\API;

use App\Models\Announcement;
use InfyOm\Generator\Request\APIRequest;
use App\Http\Requests\AppBaseFormRequest;

class UpdateAnnouncementAPIRequest extends AppBaseFormRequest
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

    public function announcement_exist(){
        return Announcement::where('title', $this->title)->where('description', $this->description)->where('id','<>', $this->id)->get();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (count($this->announcement_exist()) != 0) {
                $validator->errors()->add('announcement_exist', 'Announcement Already Exist');
            }
        });
    }
}
