<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\AnnouncementDataTable;
use App\DataTables\DepartmentAnnouncementsDataTable;
use App\DataTables\DepartmentClassScheduleDataTable;
use App\DataTables\DepartmentCourseCatalogDataTable;
use App\DataTables\DepartmentCalendarEntryDataTable;
use App\DataTables\DepartmentLecturersDataTable;
use App\DataTables\DepartmentStudentsDataTable;
use App\DataTables\DepartmentStudentEnrollmentDataTable;

use App\Http\Requests;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Http\Requests\UpdateApplicationSettings;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Repositories\CourseRepository;
use App\Repositories\StudentRepository;
use App\Repositories\ManagerRepository;
use App\Repositories\SettingRepository;
use App\Repositories\LecturerRepository;
use App\Repositories\SemesterRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\CourseClassRepository;
use App\Repositories\AnnouncementRepository;
use App\Repositories\CalendarEntryRepository;

use App\Models\User;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Department;
use App\Models\Announcement;

class AdminDashboardController extends AppBaseController
{

    /** @var  DepartmentRepository */
    private $departmentRepository;

    /** @var  CourseClassRepository */
    private $courseClassRepository;

    /** @var  AnnouncementRepository */
    private $announcementRepository;

    /** @var  CourseRepository */
    private $courseRepository;

    /** @var  CalendarEntryRepository */
    private $calendarEntryRepository;

    /** @var  StudentRepository */
    private $studentRepository;

    /** @var  SemesterRepository */
    private $semesterRepository;

    /** @var  LecturerRepository */
    private $lecturerRepository;

    /** @var  ManagerRepository */
    private $managerRepository;

    /** @var  SettingRepository */
    private $settingRepository;

    /** @var Array  */
    private $setting_keys = [
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
    ];

    public function __construct(DepartmentRepository $departmentRepo, 
                                    CourseClassRepository $courseClassRepo, 
                                    AnnouncementRepository $announcementRepo,
                                    CourseRepository $courseRepo,
                                    StudentRepository $studentRepo,
                                    SemesterRepository $semesterRepo,
                                    LecturerRepository $lecturerRepo,
                                    ManagerRepository $managerRepo,
                                    CalendarEntryRepository $calendarEntryRepo,
                                    SettingRepository $settingRepo)
    {
        $this->courseRepository = $courseRepo;
        $this->settingRepository = $settingRepo;
        $this->managerRepository = $managerRepo;
        $this->studentRepository = $studentRepo;
        $this->lecturerRepository = $lecturerRepo;
        $this->semesterRepository = $semesterRepo;
        $this->departmentRepository = $departmentRepo;
        $this->courseClassRepository = $courseClassRepo;
        $this->announcementRepository = $announcementRepo;
        $this->calendarEntryRepository = $calendarEntryRepo;        
    }

    public function index(Request $request)
    {

        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);

        $managers = $this->managerRepository->all([],null, 10);
        $semesters = $this->semesterRepository->all([],null, 10);
        $lecturers = $this->lecturerRepository->all([],null, 10);
        $departments = $this->departmentRepository->all([],null, 10);
        $announcements = Announcement::where('department_id', null)->where('course_class_id',null)->latest()->get();

        return view("dashboard.admin.index")
                ->with('department', $department)
                ->with('current_user', $current_user)
                ->with('managers', $managers)
                ->with('semesters', $semesters)
                ->with('lecturers', $lecturers)
                ->with('announcements', $announcements)
                ->with('departments', $departments);
    }

    public function displayApplicationSettings(Request $request){

        $current_user = Auth()->user();

        //Get the settings records
        $db_settings = $this->settingRepository
                            ->allWhereInQuery(['key'=>$this->setting_keys],null,100)
                            ->pluck('value','key')
                            ->toArray();

        return view("dashboard.admin.settings")
                ->with('current_user', $current_user)
                ->with('db_settings', $db_settings);
    }

    public function processApplicationSettings(UpdateApplicationSettings $request){

        //Get the settings records
        $db_settings = $this->settingRepository
                                ->allWhereInQuery(['key'=>$this->setting_keys],null,100)
                                ->pluck('id','key')
                                ->toArray();
        
        foreach($this->setting_keys as $key){
            $is_newly_created = false;

            //If the record does not exist, then create it
            if (isset($db_settings[$key])==false){
                $this->settingRepository->create([   
                    'key' => $key,
                    'value' => $request->$key
                ]);
                $is_newly_created = true;
            }
            
            //If the record exists, then update it
            if ($key=="file_icon_picture" || $key=="file_high_res_picture" || $key=="file_landing_page_picture"){

                //Handle logo file upload
                $file_upload = null;
                if ($key=="file_icon_picture" && isset($request->file_icon_picture) && $request->hasFile('file_icon_picture') ){
                    $file_upload = $request->file_icon_picture;
                }
                if ($key=="file_high_res_picture" && isset($request->file_high_res_picture) && $request->hasFile('file_high_res_picture')){
                    $file_upload = $request->file_high_res_picture;
                }
                if ($key=="file_landing_page_picture" && isset($request->file_landing_page_picture) && $request->hasFile('file_landing_page_picture')){
                    $file_upload = $request->file_landing_page_picture;
                }

                //Handle icon file upload
                if ($file_upload != null){
                    $file_type = $file_upload->getClientOriginalExtension();
                    $rndFileName = time().'.'.$file_type;
                    $file_upload->move(public_path('uploads'), $rndFileName);
                    $setting_value = "uploads/{$rndFileName}";

                    //Update the settings value.
                    $this->settingRepository->update(['value'=>$setting_value],$db_settings[$key]);
                }

            } else {
                if ($is_newly_created == false){
                    //Update the settings value.
                    $setting_value = $request->$key;
                    $this->settingRepository->update(['value'=>$setting_value],$db_settings[$key]);
                }
            }    
            
        }


        Flash::success("Application settings have been saved.");
        return redirect(route('dashboard.admin-settings'));
    }

    public function deleteApplicationSettings(Request $request, $key){
        $current_user = Auth()->user();
        if ($current_user->is_platform_admin){
            
            //Find the setting from the key and delete it.
            $db_settings = $this->settingRepository->all(['key'=>$key]);
            foreach($db_settings as $setting){
                $this->settingRepository->delete($setting->id);
            }
        }
    }

}

?>