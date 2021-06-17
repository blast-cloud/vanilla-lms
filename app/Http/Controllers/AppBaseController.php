<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;


use App\Repositories\SettingRepository;


/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{

    protected $app_settings;

    public function __construct(){
        $setting_keys = [
            'txt_app_name',
            'txt_long_name',
            'txt_short_name',
            'txt_official_website',
            'txt_official_email',
            'cbx_display_course_list',
            'cbx_display_lecturer_profiles',
            'cbx_require_enrollment_confirmation',
            'cbx_allow_lecturer_registration',
            'cbx_allow_student_registration',
            'cbx_class_enrollment',
            'txt_welcome_text',
            'txt_registration_text',
            'txt_enrollment_text',
            'file_high_res_picture',
            'file_icon_picture',
            'file_landing_page_picture',
            'txt_portal_contact_phone',
            'txt_portal_contact_name',
            'txt_portal_contact_email',
            'txt_maximum_enrollment_limit'
        ];
        
        $settingRepo = new SettingRepository(app());
        $this->app_settings = $settingRepo->allWhereInQuery(['key'=>$setting_keys],null,100)
                                    ->pluck('value','key')
                                    ->toArray();
    }

    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}
