<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\AnnouncementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Repositories\AnnouncementRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CalendarEntryRepository;
use App\Repositories\CourseClassRepository;
use App\Repositories\CourseRepository;
use App\Repositories\DepartmentRepository;
use App\Models\Semester;
use Response;
use Request;
use App\Models\Announcement;

class LecturerDashboardController extends AppBaseController
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


    public function __construct(DepartmentRepository $departmentRepo, 
                                    CourseClassRepository $courseClassRepo, 
                                    AnnouncementRepository $announcementRepo,
                                    CourseRepository $courseRepo,
                                    CalendarEntryRepository $calendarEntryRepo)
    {
        $this->courseRepository = $courseRepo;
        $this->announcementRepository = $announcementRepo;
        $this->departmentRepository = $departmentRepo;
        $this->courseClassRepository = $courseClassRepo;
        $this->calendarEntryRepository = $calendarEntryRepo;
    }

    public function index(Request $request)
    {
        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);
        $announcements = Announcement::where('department_id',$current_user->department_id)->where('course_class_id',null)
                                     ->where('announcement_end_date',">=", date("Y-m-d", time()))
                                      ->orWhere(function($query){
                                            $query->where('department_id', null)
                                                ->where('course_class_id', null)
                                                ->where('announcement_end_date',">=", date("Y-m-d", time()));
                                        })->latest()->take(5)->get();
        $current_semester = Semester::where('is_current',true)->first();
        $class_schedules = $this->courseClassRepository->all([
            'department_id' => $current_user->department_id,
            'lecturer_id'=>$current_user->lecturer_id,
            'semester_id' => optional($current_semester)->id
        ]);


        return view("dashboard.lecturer.index")
                    ->with('department', $department)
                    ->with('announcements', $announcements)
                    ->with('current_user', $current_user)
                    ->with('class_schedules', $class_schedules);

    }
}

?>