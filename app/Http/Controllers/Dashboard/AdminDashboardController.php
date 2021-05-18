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

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Repositories\CourseRepository;
use App\Repositories\StudentRepository;
use App\Repositories\ManagerRepository;
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

    public function __construct(DepartmentRepository $departmentRepo, 
                                    CourseClassRepository $courseClassRepo, 
                                    AnnouncementRepository $announcementRepo,
                                    CourseRepository $courseRepo,
                                    StudentRepository $studentRepo,
                                    SemesterRepository $semesterRepo,
                                    LecturerRepository $lecturerRepo,
                                    ManagerRepository $managerRepo,
                                    CalendarEntryRepository $calendarEntryRepo)
    {
        $this->courseRepository = $courseRepo;
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

        return view("dashboard.admin.index")
                ->with('department', $department)
                ->with('current_user', $current_user)
                ->with('managers', $managers)
                ->with('semesters', $semesters)
                ->with('lecturers', $lecturers)
                ->with('departments', $departments);
    }



}

?>