<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Announcement;

class CreateAnnouncementRequest extends AppBaseFormRequest
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
        //return Announcement::$rules;

        return [
            'title' => 'required',
            'description' => 'required',
            'announcement_end_date' => 'required|after_or_equal:today'
        ];
    }

    public function announcement_exist(){
        return Announcement::where('title', $this->title)->where('description', $this->description)->get();
    }

    public function withValidator($validator)
    {
        // $validator->after(function ($validator) {
        //     if (count($this->announcement_exist()) != 0) {
        //         $validator->errors()->add('announcement_exist', 'Announcement Already Exist');
        //     }
        // });
    }
}
