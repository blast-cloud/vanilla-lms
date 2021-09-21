<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\GradeExport;
use App\DataTables\AnnouncementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;

use Log;
use Flash;
use App\Managers\GradeManager;
use App\Http\Controllers\AppBaseController;

use App\Repositories\DepartmentRepository;
use App\Repositories\CourseClassRepository;
use App\Repositories\AnnouncementRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CalendarEntryRepository;
use App\Repositories\ClassMaterialRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\GradeRepository;
use App\Repositories\ForumRepository;
use App\Repositories\SubmissionRepository;
use App\Repositories\StudentRepository;

use App\Models\StudentAttendance;

use Carbon\Carbon;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;
use Response;
use Illuminate\Http\Request;

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

    /** @var  ForumRepository */
    private $forumRepository;

    /** @var  SubmissionRepository */
    private $submissionRepository;

    /** @var  StudentRepository */
    private $studentRepository;


    public function __construct(DepartmentRepository $departmentRepo, 
                                    CourseClassRepository $courseClassRepo, 
                                    AnnouncementRepository $announcementRepo,
                                    CourseRepository $courseRepo,
                                    CalendarEntryRepository $calendarEntryRepo,
                                    ClassMaterialRepository $classMaterialRepo,
                                    EnrollmentRepository $enrollmentRepo,
                                    GradeRepository $gradeRepo,
                                    ForumRepository $forumRepo,
                                    SubmissionRepository $submissionRepo,
                                    StudentRepository $studentRepo)
    {
        $this->courseRepository = $courseRepo;
        $this->announcementRepository = $announcementRepo;
        $this->departmentRepository = $departmentRepo;
        $this->courseClassRepository = $courseClassRepo;
        $this->calendarEntryRepository = $calendarEntryRepo;
        $this->classMaterialRepository = $classMaterialRepo;
        $this->enrollmentRepository = $enrollmentRepo;
        $this->gradeRepository = $gradeRepo;
        $this->forumRepository = $forumRepo;
        $this->submissionRepository = $submissionRepo;
        $this->studentRepository = $studentRepo;
    }
    
    public function index(Request $request, $id)
    {
        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);
        $courseClass = $this->courseClassRepository->find($id);
        $course_class = $courseClass->id;

        $remainingGradePct = 0;
        $lecture_notes = $this->classMaterialRepository->all(['course_class_id'=>$id,'type'=>'lecture-notes']);
        $reading_materials = $this->classMaterialRepository->all(['course_class_id'=>$id,'type'=>'reading-materials']);
        $class_assignments = $this->classMaterialRepository->all(['course_class_id'=>$id,'type'=>'class-assignments']);
        $class_examinations = $this->classMaterialRepository->all(['course_class_id'=>$id,'type'=>'class-examinations']);
        $lecture_classes = $this->classMaterialRepository->all(['course_class_id'=>$id,'type'=>'lecture-classes']);
        
        $forums = $this->forumRepository->all(['course_class_id'=>$id,'parent_forum_id'=>null]);
        $grades = $this->gradeRepository->all(['course_class_id'=>$id]);
        $enrollments = $this->enrollmentRepository->all(['course_class_id'=>$id]);

        if ($current_user->manager_id != null){
            $class_schedules = $this->courseClassRepository->all(['department_id'=>$current_user->department_id]);

        }else if ($current_user->student_id != null){

            $student_enrollment_ids = [];
            $student_enrollments = $this->enrollmentRepository->all(['student_id'=>$current_user->student_id]);
            foreach ($student_enrollments as $item){
                $student_enrollment_ids []= $item->course_class_id;
            }
            $grades = $this->gradeRepository->all(['course_class_id'=>$id,'student_id'=>$current_user->student_id]);
            $class_schedules = $this->courseClassRepository->findMany($student_enrollment_ids);
    
        }else if ($current_user->lecturer_id != null){
            $class_schedules = $this->courseClassRepository->all(['lecturer_id'=>$current_user->lecturer_id]);
            $course_class = $courseClass->id;
            $gradePctSum = $this->classMaterialRepository->all(['course_class_id'=>$course_class])->sum('grade_contribution_pct');
            $remainingGradePct = 100 - $gradePctSum; 
              
        }else{
            $class_schedules = null;
        }

        $gradeManager = new GradeManager($id);
        // dd($gradeManager);

        return view("dashboard.class.index")
                    ->with('department', $department)
                    ->with('courseClass', $courseClass)
                    ->with('current_user', $current_user)
                    ->with('class_schedules', $class_schedules)
                    ->with('lecture_notes', $lecture_notes)
                    ->with('reading_materials', $reading_materials)
                    ->with('class_assignments', $class_assignments)
                    ->with('class_examinations', $class_examinations)
                    ->with('lecture_classes', $lecture_classes)
                    ->with('grades', $grades)
                    ->with('forums', $forums)
                    ->with('gradeManager', $gradeManager)
                    ->with('enrollments', $enrollments)
                    ->with('remainingGradePct', $remainingGradePct);
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

    public function processStudentAttendanceDetails(Request $request, $course_class_id, $lectureId)
    {
        $current_user = Auth()->user();
        $lecture_photo = new StudentAttendance;

        //Upload Captured Image
        $captured_image = $request->student_img;  // base64 encoded
        $captured_image = str_replace('data:image/jpeg;base64,', '', $captured_image);
        $captured_image = str_replace(' ', '+', $captured_image);
        $captured_image_name = time(). '.jpeg';
    
        $storagePath = public_path('/uploads/'.$captured_image_name);
        file_put_contents($storagePath, base64_decode($captured_image));

        $lecture_photo->student_id        = $current_user->student_id;
        $lecture_photo->course_class_id   = $course_class_id;
        $lecture_photo->class_material_id = $lectureId;
        $lecture_photo->photo_file_path   = $captured_image_name;
        $lecture_photo->save();
        return true;
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

    public function listOfSubmittedAssignment(Request $request, $course_class_id, $class_material_id)
    {
        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);

        $courseClass = $this->courseClassRepository->find($course_class_id);

        $assignment_submissions = $this->submissionRepository->all(['course_class_id'=>$course_class_id,'class_material_id'=>$class_material_id]);
        $assignment_submissions = $assignment_submissions->pluck('upload_file_path','student_id');

        $grades = $this->gradeRepository->all(['course_class_id'=>$course_class_id,'class_material_id'=>$class_material_id]);
        $grades = $grades->pluck('score','student_id');

        $enrollments = $this->enrollmentRepository->all(['course_class_id'=>$course_class_id]);
        $class_material = $this->classMaterialRepository->find($class_material_id);


        if ($current_user->lecturer_id != null){
            $class_schedules = $this->courseClassRepository->all(['lecturer_id'=>$current_user->lecturer_id]);
        }else{
            $class_schedules = null;
        }

        return view("dashboard.class.student_submissions")
                    ->with('department', $department)
                    ->with('courseClass', $courseClass)
                    ->with('current_user', $current_user)
                    ->with('class_material', $class_material)
                    ->with('assignment_submissions', $assignment_submissions)
                    ->with('enrollments', $enrollments)
                    ->with('class_schedules', $class_schedules)
                    ->with('grades', $grades);
    }

    public function processGradeUpdate(Request $request, $course_class_id)
    {
        $current_user = Auth()->user();
        $error_messages = [];
        $final_scores = [];

        foreach(json_decode($request->grade_list) as $idx=>$grade){
                
            //Find student by matric number.
            $student = $this->studentRepository->first(['matriculation_number'=>$grade->student_matric]);

            if ($student != null){

                //Ensure student is enrolled in course
                $enrollment = $this->enrollmentRepository->first(['course_class_id'=>$course_class_id,'student_id'=>$student->id]);
                if ($enrollment != null){

                    //Ensure the current user is the lecturer for the course class
                    if ($enrollment->courseClass->lecturer_id == $current_user->lecturer_id){

                        $max_score_points = 0;
                        if (isset($grade->max_mp) && is_numeric($grade->max_mp) && $grade->max_mp>0){
                            $max_score_points = $grade->max_mp;
                        }
            
                        
                        if (is_numeric($grade->score) && $grade->score>= 0 && $grade->score <= $max_score_points){

                            //Create a map to query the grade table OR create a new grade if needed.
                            $grade_query = ['course_class_id'=>$course_class_id,'student_id'=>$student->id,'grade_title'=>$grade->type];

                            //Check the grade type for exams
                            if ($grade->type=="exam" && isset($grade->exam_id)){
                                $grade_query['class_material_id'] = $grade->exam_id;
                            }

                            //Check the grade type for assignments
                            if ($grade->type=="assignment" && isset($grade->assignment_id)){
                                $grade_query['class_material_id'] = $grade->assignment_id;
                            }

                            //Find the grade based on the query
                            $grade_model = $this->gradeRepository->first($grade_query);

                            //Add the grade score to the grade query
                            $grade_query['score'] = $grade->score;

                            //Check the the grade already exists, 
                            if ($grade_model != null){
                                if ($grade->score != $grade_model->score){
                                    //Update grade record if the record exists and the grade is different,
                                    $this->gradeRepository->update($grade_query, $grade_model->id);
                                }
                            } else {
                                //Create a new grade since one doesn't exist.
                                $this->gradeRepository->create($grade_query);
                            }

                        } else{

                            //Grade must be between 0 and 100
                            if (!empty($grade->score)){

                                $selector = "";
                                if ($grade->type=="assignment"){    $selector="as-{$grade->assignment_id}";  }
                                else if ($grade->type=="exam"){     $selector="es-{$grade->exam_id}";        }

                                $error_messages["{$selector}-{$grade->student_matric}"]= "The {$grade->label} score submitted ({$grade->score}) for {$grade->student_matric} must be a numeric value between 0 and {$max_score_points}.";
                            }
                        }
                    
                    }else{
                        //Lecturer not teaching the class
                        $error_messages[]= "You are not assigned to teach this class and cannot update grades for student {$grade->student_matric}";
                    }
                } else {
                    //No enrollment
                    $error_messages[]= "Student {$grade->student_matric} is not enrolled in this class and the grade cannot be updated";
                }

                //Compute Final Score
                $final_score = \App\Managers\GradeManager::computeFinalScore($course_class_id, $grade->student_matric);

                $grade_query = ['grade_title'=>'final','course_class_id'=>$course_class_id,'student_id'=>$student->id];
                $final_grade = $this->gradeRepository->first($grade_query);
                
                $grade_query['score'] = $final_score;
                if ($final_grade != null){
                    $this->gradeRepository->update($grade_query, $final_grade->id);
                } else {
                    $this->gradeRepository->create($grade_query);
                }

                $final_scores["fs-{$grade->student_matric}"] = $final_score;

            } else {
                //No student
                $error_messages[]= "Invalid student record {$grade->student_matric}";
            }

        }

        return $this->sendResponse($final_scores,$error_messages);
        
    }

    public function processGradeExport(Request $request, $course_class_id){


        $grade_exporter = new GradeExport(
            $this->departmentRepository, 
            $this->courseClassRepository, 
            $this->classMaterialRepository,
            $this->enrollmentRepository,
            $course_class_id
        );

        return \Maatwebsite\Excel\Facades\Excel::download($grade_exporter, 'invoices.xlsx');
    }

}

?>