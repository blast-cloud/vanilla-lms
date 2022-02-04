<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\AnnouncementDataTable;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Repositories\AnnouncementRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CalendarEntryRepository;
use App\Repositories\ClassMaterialRepository;
use App\Repositories\CourseClassRepository;
use App\Repositories\SettingRepository;
use App\Repositories\CourseRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\GradeRepository;
use App\Repositories\SemesterRepository;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\Semester;
use App\Models\Lecturer;
use DB;
use Response;
use Request;
use App\Models\Announcement;
use App\Managers\StudentActivityManager;

class StudentDashboardController extends AppBaseController
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

    /** @var  ClassMaterialRepository */
    private $classMaterialRepository;

    /** @var  EnrollmentRepository */
    private $enrollmentRepository;

    /** @var  GradeRepository */
    private $gradeRepository;

    /** @var  SemesterRepository */
    private $semesterRepository;

    /** @var  SettingRepository */
    private $settingRepository;
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
                                    CalendarEntryRepository $calendarEntryRepo,
                                    ClassMaterialRepository $classMaterialRepo,
                                    EnrollmentRepository $enrollmentRepo,
                                    SettingRepository $settingRepo,
                                    GradeRepository $gradeRepo,
                                    SemesterRepository $semesterRepo)
    {
        $this->courseRepository = $courseRepo;
        $this->announcementRepository = $announcementRepo;
        $this->departmentRepository = $departmentRepo;
        $this->courseClassRepository = $courseClassRepo;
        $this->calendarEntryRepository = $calendarEntryRepo;
        $this->classMaterialRepository = $classMaterialRepo;
        $this->enrollmentRepository = $enrollmentRepo;
        $this->gradeRepository = $gradeRepo;
        $this->settingRepository = $settingRepo;
        $this->semesterRepository = $semesterRepo;
    }
    
    public function index(Request $request)
    {
        $current_user = Auth()->user();

       
        $semesterItems = $this->semesterRepository->all();
        $departmentItems = $this->departmentRepository->all();
        $enrollment_ids = [];
        $enrollments = $this->enrollmentRepository->all(['student_id'=>$current_user->student_id]);
        foreach ($enrollments as $item){
            $enrollment_ids []= $item->course_class_id;
        }

        $announcements = Announcement::where('department_id',$current_user->department_id)
                                        ->where('course_class_id',null)
                                        ->orWhere(function($query){
                                            $query->where('department_id', null)
                                                ->where('course_class_id', null);
                                        })->latest()->get();
        $class_schedules = CourseClass::with('enrollments')->findMany($enrollment_ids);
        $department = $this->departmentRepository->find($current_user->department_id);
        $classActivities = new StudentActivityManager(1);
        $current_semester = Semester::where('is_current',true)->first();
    
        return view("dashboard.student.index")
                ->with('department', $department)
                ->with('announcements', $announcements)
                ->with('current_semester',$current_semester)
                ->with('current_user', $current_user)
                ->with('class_schedules', $class_schedules)
                ->with('classActivities',$classActivities)
                ->with('semesterItems', $semesterItems)
                ->with('departmentItems',$departmentItems);
    }

}

?>