<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationSettings extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = Auth()->user();
        return $current_user->is_platform_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'txt_app_name'=>'nullable|string|max:200',
            'txt_long_name'=>'nullable|string|max:200',
            'txt_short_name'=>'nullable|string|max:50',
            'txt_official_website'=>'nullable|url|max:200',
            'txt_official_email'=>'nullable|email|max:200',
            'cbx_display_course_list'=>'nullable|numeric',
            'cbx_display_lecturer_profiles'=>'nullable|numeric',
            'cbx_require_enrollment_confirmation'=>'nullable|numeric',
            'cbx_allow_lecturer_registration'=>'nullable|numeric',
            'cbx_allow_student_registration'=>'nullable|numeric',
            'cbx_class_enrollment'=>'nullable|numeric',
            'txt_welcome_text'=>'nullable|string|max:2000',
            'txt_registration_text'=>'nullable|string|max:2000',
            'txt_enrollment_text'=>'nullable|string|max:2000',
            'file_high_res_picture'=>'nullable|file|max:2048|mimes:jpeg,png,jpg',
            'file_icon_picture'=>'nullable|file|max:1024|mimes:jpeg,png,jpg',
            'file_landing_page_picture'=>'nullable|file|max:2048|mimes:jpeg,png,jpg',
            'txt_portal_contact_phone'=>'nullable|numeric|digits:11',
            'txt_portal_contact_name'=>'nullable|string|max:50',
            'txt_portal_contact_email'=>'nullable|email|max:100',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file_high_res_picture.max' => "Maximum file size to upload is 2MB. If you are uploading a photo, try to reduce its resolution to make it under 2MB",
            'file_landing_page_picture.max' => "Maximum file size to upload is 2MB. If you are uploading a photo, try to reduce its resolution to make it under 2MB",
            'file_icon_picture.max' => "Maximum file size to upload is 1MB. If you are uploading a photo, try to reduce its resolution to make it under 1MB"
        ];
    }


    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'txt_app_name'=>'Application Name',
            'txt_long_name'=>'Organization Name',
            'txt_short_name'=>'Short Name (Abbrivation)',
            'txt_official_website'=>'Official Website Address',
            'txt_official_email'=>'Office Email Address',
            'cbx_display_course_list'=>'Display Course List on Home Page',
            'cbx_display_lecturer_profiles'=>'Display Lecturer Profile on Home Page',
            'cbx_require_enrollment_confirmation'=>'Require Enrollment Confirmation',
            'cbx_allow_lecturer_registration'=>'Allow Lecturer Self Registration',
            'cbx_allow_student_registration'=>'Allow Student Self Registration',
            'cbx_class_enrollment'=>'All Student Self Enrollment in Class',
            'txt_welcome_text'=>'Welcome Text',
            'txt_registration_text'=>'Registration Text',
            'txt_enrollment_text'=>'Enrollment Text',
            'file_high_res_picture'=>'Logo File',
            'file_icon_picture'=>'Icon File',
            'file_landing_page_picture'=>'Landing Page File',
            'txt_portal_contact_phone'=>'Portal Contact Phone Number',
            'txt_portal_contact_name'=>'Portal Contact Name',
            'txt_portal_contact_email'=>'Portal Contact Email',
        ];
    }
}
