<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CalendarEntry;

class UpdateCalendarEntryRequest extends AppBaseFormRequest
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
        $rules = CalendarEntry::$rules;
        
        return $rules;
        */

        return [
            'id' => 'required|numeric|exists:calendar_entries,id',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:100000'
        ];
    }

    public function calendarentry_exist(){
        return CalendarEntry::where('title', $this->title)->where('due_date', $this->due_date)->where('description', $this->description)->where('id','<>', $this->id)->get();
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
