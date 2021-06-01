<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CalendarEntry;

class CreateCalendarEntryRequest extends AppBaseFormRequest
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
        //return CalendarEntry::$rules;

        return [
            'title' => 'required',
            'due_date' => 'required',
            'description' => 'required'
        ];
    }

    public function calendarentry_exist(){
        return CalendarEntry::where('title', $this->title)->where('due_date', $this->due_date)->where('description', $this->description)->get();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (count($this->calendarentry_exist()) != 0) {
                $validator->errors()->add('announcement_exist', 'Calendar Already Exist');
            }
        });
    }
}
