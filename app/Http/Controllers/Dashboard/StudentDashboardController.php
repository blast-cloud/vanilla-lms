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
use App\Repositories\CourseRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\GradeRepository;
use Response;
use Request;

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

    public function __construct(DepartmentRepository $departmentRepo, 
                                    CourseClassRepository $courseClassRepo, 
                                    AnnouncementRepository $announcementRepo,
                                    CourseRepository $courseRepo,
                                    CalendarEntryRepository $calendarEntryRepo,
                                    ClassMaterialRepository $classMaterialRepo,
                                    EnrollmentRepository $enrollmentRepo,
                                    GradeRepository $gradeRepo)
    {
        $this->courseRepository = $courseRepo;
        $this->announcementRepository = $announcementRepo;
        $this->departmentRepository = $departmentRepo;
        $this->courseClassRepository = $courseClassRepo;
        $this->calendarEntryRepository = $calendarEntryRepo;
        $this->classMaterialRepository = $classMaterialRepo;
        $this->enrollmentRepository = $enrollmentRepo;
        $this->gradeRepository = $gradeRepo;
    }
    
    public function index(Request $request)
    {
        $current_user = Auth()->user();
        
        $enrollment_ids = [];
        $enrollments = $this->enrollmentRepository->all(['student_id'=>$current_user->student_id]);
        foreach ($enrollments as $item){
            $enrollment_ids []= $item->course_class_id;
        }

        $class_schedules = $this->courseClassRepository->findMany($enrollment_ids);

        return view("dashboard.student.index")
                ->with('current_user', $current_user)
                ->with('class_schedules', $class_schedules);
    }

}

?>