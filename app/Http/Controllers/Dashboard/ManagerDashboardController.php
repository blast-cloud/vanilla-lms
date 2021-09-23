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

use DB;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Repositories\CourseRepository;
use App\Repositories\StudentRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\CourseClassRepository;
use App\Repositories\AnnouncementRepository;
use App\Repositories\CalendarEntryRepository;
use Illuminate\Support\Collection;

use App\Models\User;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Department;
use App\Models\Semester;
use App\Models\CourseClass;
use App\Models\Announcement;
use App\Models\CalendarEntry;


class ManagerDashboardController extends AppBaseController
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


    public function __construct(DepartmentRepository $departmentRepo, 
                                    CourseClassRepository $courseClassRepo, 
                                    AnnouncementRepository $announcementRepo,
                                    CourseRepository $courseRepo,
                                    StudentRepository $studentRepo,
                                    CalendarEntryRepository $calendarEntryRepo)
    {
        $this->courseRepository = $courseRepo;
        $this->studentRepository = $studentRepo;
        $this->announcementRepository = $announcementRepo;
        $this->departmentRepository = $departmentRepo;
        $this->courseClassRepository = $courseClassRepo;
        $this->calendarEntryRepository = $calendarEntryRepo;        
    }

    public function index(Request $request)
    {

        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);

        $announcements = Announcement::where('department_id',$current_user->department_id)->where('course_class_id',null)->get();
        $class_schedules = $this->courseClassRepository->all(['department_id'=>$current_user->department_id],null, 10);

        $department_calendar_items = CalendarEntry::where('department_id',$current_user->department_id)->get();
        $course_catalog_items = Course::where('department_id', $current_user->department_id)->get();
        $student_count = $this->studentRepository->all(['department_id'=>$current_user->department_id])->count();
        $calendars = $department_calendar_items->sortByDesc('due_date');
        $currentDate = date('Y/m/d');
        $lessThanCurrentDate = new Collection();
        $equalToCurrentDate = new Collection();
        foreach ($calendars as $key => $value) {
            if((date('Y/m/d', strtotime($value['due_date']))) == $currentDate){
                $equalToCurrentDate[] = $value; ;
                unset($calendars[$key]);
            }
            if((date('Y/m/d', strtotime($value['due_date']))) < $currentDate){
                $lessThanCurrentDate[] = $value;
                unset($calendars[$key]);
            }
        }
        $calendars->sortBy('due_date');
        $department_calendar_items = collect( $equalToCurrentDate)->merge($calendars)->merge( $lessThanCurrentDate);

        $class_schedules_unassigned = $this->courseClassRepository->all([
            'lecturer_id'=>null,
            'department_id'=>$current_user->department_id
        ]);

        $courseItems = Course::select(DB::raw("CONCAT(name,' - ',code) AS full_name"),'id')
                            ->pluck('full_name','id')
                            ->toArray();

        $semesterItems = Semester::all()->pluck('code','id');

        $lecturerItems = Lecturer::select(DB::raw("CONCAT(COALESCE(job_title, ''),' ',last_name,', ',first_name) AS name"),'id')
                            ->pluck('name','id')
                            ->toArray();

        return view("dashboard.manager.index")
                    ->with('department', $department)
                    ->with('current_user', $current_user)
                    ->with('announcements', $announcements)
                    ->with('class_schedules', $class_schedules)
                    ->with('courseItems', $courseItems)
                    ->with('student_count', $student_count)
                    ->with('lecturerItems', $lecturerItems)
                    ->with('semesterItems', $semesterItems)
                    ->with('department_calendar_items', $department_calendar_items)
                    ->with('course_catalog_items', $course_catalog_items)
                    ->with('class_schedules_unassigned', $class_schedules_unassigned);
    }

    public function displayAnnouncements(Request $request)
    {

        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);
        $class_schedules = $this->courseClassRepository->all(['department_id'=>$current_user->department_id],null, 10);
        $announcementDataTable = new DepartmentAnnouncementsDataTable($current_user->department_id);

        if ($request->expectsJson()) {
            return $announcementDataTable->ajax();
        }

        return view("dashboard.manager.tables.announcements")
                    ->with('department', $department)
                    ->with('class_schedules', $class_schedules)
                    ->with('current_user', $current_user)
                    ->with('dataTable', $announcementDataTable->html());
    }

    public function displayClassSchedules(Request $request)
    {

        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);
        $class_schedules = $this->courseClassRepository->all(['department_id'=>$current_user->department_id],null, 10);
        $class_schedulesDataTable = new DepartmentClassScheduleDataTable($current_user->department_id);

        if ($request->expectsJson()) {
            return $class_schedulesDataTable->ajax();
        }

        $courseItems = Course::select(DB::raw("CONCAT(name,' - ',code) AS full_name"),'id')
                            ->where('department_id', $current_user->department_id )
                            ->pluck('full_name','id')
                            ->toArray();

        $semesterItems = Semester::all()->pluck('code','id');

        $lecturerItems = Lecturer::select(DB::raw("CONCAT(COALESCE(job_title, ''),' ',last_name,', ',first_name) AS name"),'id')
                            ->where('department_id', $current_user->department_id )
                            ->pluck('name','id')
                            ->toArray();

        return view("dashboard.manager.tables.class_schedules")
                    ->with('department', $department)
                    ->with('class_schedules', $class_schedules)
                    ->with('current_user', $current_user)
                    ->with('courseItems', $courseItems)
                    ->with('lecturerItems', $lecturerItems)
                    ->with('semesterItems', $semesterItems)
                    ->with('dataTable', $class_schedulesDataTable->html());
    }

    public function displayCourseCatalog(Request $request)
    {

        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);
        $class_schedules = $this->courseClassRepository->all(['department_id'=>$current_user->department_id],null, 10);
        $courseCatalogDataTable = new DepartmentCourseCatalogDataTable($current_user->department_id);

        if ($request->expectsJson()) {
            return $courseCatalogDataTable->ajax();
        }

        return view("dashboard.manager.tables.course_catalog")
                    ->with('department', $department)
                    ->with('class_schedules', $class_schedules)
                    ->with('current_user', $current_user)
                    ->with('dataTable', $courseCatalogDataTable->html());
    }

    public function displayDepartmentCalendar(Request $request)
    {

        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);
        $class_schedules = $this->courseClassRepository->all(['department_id'=>$current_user->department_id],null, 10);
        $calendarItemDataTable = new DepartmentCalendarEntryDataTable($current_user->department_id);
        
        if ($request->expectsJson()) {
            return $calendarItemDataTable->ajax();
        }

        return view("dashboard.manager.tables.department_calendar")
                    ->with('department', $department)
                    ->with('class_schedules', $class_schedules)
                    ->with('current_user', $current_user)
                    ->with('dataTable', $calendarItemDataTable->html());
    }

    public function displayDepartmentLecturers(Request $request)
    {

        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);
        $class_schedules = $this->courseClassRepository->all(['department_id'=>$current_user->department_id],null, 10);
        $lecturersDataTable = new DepartmentLecturersDataTable($current_user->department_id);

        if ($request->expectsJson()) {
            return $lecturersDataTable->ajax();
        }


        return view("dashboard.manager.tables.lecturers")
                    ->with('department', $department)
                    ->with('class_schedules', $class_schedules)
                    ->with('current_user', $current_user)
                    ->with('dataTable', $lecturersDataTable->html());
    }

    public function displayDepartmentStudents(Request $request)
    {

        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);
        $class_schedules = $this->courseClassRepository->all(['department_id'=>$current_user->department_id],null, 10);
        $studentsDataTable = new DepartmentStudentsDataTable($current_user->department_id);

       

        if ($request->expectsJson()) {
            return $studentsDataTable->ajax();
        }

        return view("dashboard.manager.tables.students")
                    ->with('department', $department)
                    ->with('class_schedules', $class_schedules)
                    ->with('current_user', $current_user)
                    ->with('dataTable', $studentsDataTable->html());
    }

    public function displayDepartmentStudentPage(Request $request, $student_id)
    {
        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);
        $class_schedules = $this->courseClassRepository->all(['department_id'=>$current_user->department_id],null, 20);
        
        $studentEnrollmentDataTable = new DepartmentStudentEnrollmentDataTable($student_id);
        $student = $this->studentRepository->find($student_id);

        if ($request->expectsJson()) {
            return $studentEnrollmentDataTable->ajax();
        }

        /* $courseItems = $class_schedules->pluck('name','id')->toArray(); */
        $courseItems = CourseClass::where('department_id', $current_user->department_id)->get();

        return view("dashboard.manager.student")
                    ->with('student', $student)
                    ->with('department', $department)
                    ->with('courseItems', $courseItems)
                    ->with('current_user', $current_user)
                    ->with('class_schedules', $class_schedules)
                    ->with('dataTable', $studentEnrollmentDataTable->html());
    }

}
?>