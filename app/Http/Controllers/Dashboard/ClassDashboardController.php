<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\AnnouncementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;

use Flash;
use App\Http\Controllers\AppBaseController;

use App\Repositories\DepartmentRepository;
use App\Repositories\CourseClassRepository;
use App\Repositories\AnnouncementRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CalendarEntryRepository;
use App\Repositories\ClassMaterialRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\GradeRepository;
use Carbon\Carbon;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;
use Response;
use Request;

class ClassDashboardController extends AppBaseController
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
    

    public function index(Request $request, $id)
    {
        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);
        $courseClass = $this->courseClassRepository->find($id);

        $lecture_notes = $this->classMaterialRepository->all(['course_class_id'=>$id,'type'=>'lecture-notes']);
        $reading_materials = $this->classMaterialRepository->all(['course_class_id'=>$id,'type'=>'reading-materials']);
        $class_assignments = $this->classMaterialRepository->all(['course_class_id'=>$id,'type'=>'class-assignments']);
        $lecture_classes = $this->classMaterialRepository->all(['course_class_id'=>$id,'type'=>'lecture-classes']);
        
        $grades = $this->gradeRepository->all(['course_class_id'=>$id]);
        $enrollments = $this->enrollmentRepository->all(['course_class_id'=>$id]);

        if ($current_user->manager_id != null){
            $class_schedules = $this->courseClassRepository->all(['department_id'=>$current_user->department_id]);

        }else if ($current_user->student_id != null){

            $enrollment_ids = [];
            $enrollments = $this->enrollmentRepository->all(['student_id'=>$current_user->student_id]);
            foreach ($enrollments as $item){
                $enrollment_ids []= $item->course_class_id;
            }
            $grades = $this->gradeRepository->all(['course_class_id'=>$id,'student_id'=>$current_user->student_id]);
            $class_schedules = $this->courseClassRepository->findMany($enrollment_ids);
    
        }else if ($current_user->lecturer_id != null){
            $class_schedules = $this->courseClassRepository->all(['lecturer_id'=>$current_user->lecturer_id]);
        }else{
            $class_schedules = null;
        }

        return view("dashboard.class.index")
                    ->with('department', $department)
                    ->with('courseClass', $courseClass)
                    ->with('current_user', $current_user)
                    ->with('class_schedules', $class_schedules)
                    ->with('lecture_notes', $lecture_notes)
                    ->with('reading_materials', $reading_materials)
                    ->with('class_assignments', $class_assignments)
                    ->with('lecture_classes', $lecture_classes)
                    ->with('grades', $grades)
                    ->with('enrollments', $enrollments);
    }

    public function processJoinOnlineLecture(Request $request, $id, $lectureId)
    {
        $current_user = Auth()->user();
        $courseClass = $this->courseClassRepository->find($id);
        $lectureMaterial = $this->classMaterialRepository->find($lectureId);

        $displayName = "{$current_user->name}";
        $password = 'PW$$attendee';
        $password = 'PW$$moderator';

        if ($current_user->lecturer_id!=null){
            $password = 'PW$$moderator';
        }

        $join_info = [   
            'meetingID' => $lectureMaterial->blackboard_meeting_id,
            'fullName' => $displayName,
            'userName' => $displayName,
            'password' => $password,
            'redirect' => true,
            //'userId' =>  $current_user->id,
        ];

        //dd($join_info);
        $bbb_join = Bigbluebutton::join($join_info);

        //dd(Bigbluebutton::all());
        //dd($bbb_join);

        return redirect()->to($bbb_join);
    }

    public function processEndOnlineLecture(Request $request, $id, $lectureId)
    {
        $current_user = Auth()->user();
        $courseClass = $this->courseClassRepository->find($id);        

        $this->classMaterialRepository->update(
            ['blackboard_meeting_status' => "ended"],
            $lectureId
        );

        return redirect()->route('dashboard.class',$id);
    }

    public function processRecordingOnlineLecture(Request $request, $id, $lectureId)
    {
        $current_user = Auth()->user();
        $courseClass = $this->courseClassRepository->find($id);
        $lectureMaterial = $this->classMaterialRepository->find($lectureId);

        $bbb_recordings = Bigbluebutton::getRecordings([
            'meetingID' => $lectureMaterial->blackboard_meeting_id,
        ]);

        if ($bbb_recordings != null && count($bbb_recordings)>0){
            Bigbluebutton::publishRecordings([
                'recordID' => $bbb_recordings[0]->recordID,
                'state' => true //default is true  
            ]);

            $this->classMaterialRepository->update([   
                'blackboard_meeting_status' => "video-available",
                'reference_material_url' => $bbb_recordings[0]->playback->format[1]->url
                ], $lectureId
            );
        }

    }

    public function processStartOnlineLecture(Request $request, $id, $lectureId)
    {
        $current_user = Auth()->user();
        $courseClass = $this->courseClassRepository->find($id);
        $lectureMaterial = $this->classMaterialRepository->find($lectureId);

        $bbb_available = Bigbluebutton::isConnect();
        if ($bbb_available){

            $meeting_id = "room-{$id}-{$lectureId}";
            $lecture_material = $this->classMaterialRepository->update([
                'blackboard_meeting_id' => $meeting_id,
                'blackboard_meeting_status' => "in-progress",
                'course_class_id' => $id
            ], $lectureId);

            $bbb_room = Bigbluebutton::create([
                'meetingID' => $meeting_id,
                'meetingName' => $lectureMaterial->title,
                'attendeePW' => 'PW$$attendee',
                'moderatorPW' => 'PW$$moderator',
                'endCallbackUrl'  => route('dashboard.class.end-lecture',[$id,$lecture_material->id]),
                'bbb-recording-ready-url'  => route('dashboard.class.record-lecture',[$id,$lecture_material->id]),
                'record' => true,
                'muteOnStart' => true,
            ]);

            if ($bbb_room != null && count($bbb_room)>0)
            {
                if ($current_user->lecturer_id!=null){
                    return redirect()->route('dashboard.class.join-lecture',[$id,$lecture_material->id]);
                }
                return redirect()->route('dashboard.class',$id);
            }
        }else{
            return redirect()->back()->withErrors(['msg','The blackboard server is not available at this moment. Try again.']);
        }
    }



}

?>