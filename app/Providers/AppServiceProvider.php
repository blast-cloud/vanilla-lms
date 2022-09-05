<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Schema;
use View;

use Illuminate\Support\Facades\Log;
use App\Repositories\SettingRepository;
use App\Models\Semester;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $app_settings = [];
        if (Schema::hasTable('settings') == true){
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
                'txt_maximum_enrollment_limit',
                'txt_school_max_level'
            ];
            
            $settingRepo = new SettingRepository(app());
            $app_settings = $settingRepo->allWhereInQuery(['key'=>$setting_keys],null,100)
                                        ->pluck('value','key')
                                        ->toArray();
        }
        if(Schema::hasTable('semesters')){
            try{
                
                $current_semester = Semester::where('is_current',true)->first();
                View::share('current_semester',$current_semester);

            } catch (\Illuminate\Database\QueryException $e) {
                Log::info("Unable to set current semester");
            }
        }

        View::share('app_settings', $app_settings);
        Schema::DefaultStringLength(191);
    }
    
}
