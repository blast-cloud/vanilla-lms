<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\GradeExport;
use App\DataTables\AnnouncementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Http\Requests\GradeCommentRequest;
use Carbon\Carbon;
use App\Models\Semester;

use Log;
use Flash;
use Illuminate\Support\Str;
use App\Managers\GradeManager;
use App\Managers\StudentActivityManager;
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
use App\Repositories\SemesterRepository;
use App\Models\Submission;
use App\Models\Grade;

use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Parameters\EndMeetingParameters;
use BigBlueButton\Parameters\GetRecordingsParameters;
use App\Models\StudentAttendance;
use App\Models\ClassMaterial;
use App\Models\CourseClass;
use App\Models\CourseClassFeedback;
use App\Models\CourseClassFeedbackResponse;
use App\Models\StudentClassActivity;
use App\Models\Student;
use App\Models\User;
use App\Models\Forum;
use App\Models\Level;
use Response;
use Illuminate\Http\Request;
use DB;
use App\Repositories\StudentClassActivityRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
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

    /** @var  StudentClassActivityRepository */
    private $studentClassActivityRepository;

 /** @var   private $SemesterRepository */
 private $semesterRepository;


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
                                    StudentRepository $studentRepo,
                                    StudentClassActivityRepository $studentClassActivityRepo,
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
        $this->forumRepository = $forumRepo;
        $this->submissionRepository = $submissionRepo;
        $this->studentRepository = $studentRepo;
        $this->studentClassActivityRepository = $studentClassActivityRepo;
        $this->semesterRepository =$semesterRepo;
    }
    
    public function index(Request $request, $id)
    {
        $current_user = Auth()->user();
        $department = $this->departmentRepository->find($current_user->department_id);
        $departmentItems = $this->departmentRepository->all()->sortBy('name');
        $courseClass = $this->courseClassRepository->find($id);
        $feedback_requests = CourseClassFeedback::all();
        $course_class_feedback_requests = CourseClassFeedback::where('course_class_id', $courseClass->id)->count();
        $feedback_responses = CourseClassFeedbackResponse::all();
        $students = Student::all();
        $current_semester = Semester::where('is_current',true)->first();
        $assignment_submissions = Submission::where('course_class_id',$courseClass->id)->get();
        $course_class = $courseClass->id;
        $remainingGradePct = 100;
        $forums = $this->forumRepository->all(['course_class_id'=>$id,'parent_forum_id'=>null]);
        $grades = $this->gradeRepository->all(['course_class_id'=>$id]);
        $enrollments = $this->enrollmentRepository->all(['course_class_id'=>$id]);
        $timeObj = new Carbon;
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
            $gradePctSum = ClassMaterial::where(['course_class_id'=>$course_class])->sum('grade_contribution_pct');
            
            $remainingGradePct = 100 - $gradePctSum; 
              
        }else{
            $class_schedules = null;
        }

        $gradeManager = new GradeManager($id);
    
        $classActivities = new StudentActivityManager($id);

        $levels = Level::orderBy('level')->get();

       
        return view("dashboard.class.index")
                    ->with('levels',$levels)
                    ->with('department', $department)
                    ->with('courseClass', $courseClass)
                    ->with('current_user', $current_user)
                    ->with('class_schedules', $class_schedules)
                    ->with('grades', $grades)
                    ->with('forums', $forums)
                    ->with('gradeManager', $gradeManager)
                    ->with('enrollments', $enrollments)
                    ->with('remainingGradePct', $remainingGradePct)
                    ->with('classActivities',$classActivities)
                    ->with('departmentItems',$departmentItems)
                    ->with('students', $students)
                    ->with('assignment_submissions',  $assignment_submissions)
                    ->with('feedback_requests', $feedback_requests)
                    ->with('feedback_responses', $feedback_responses)
                    ->with('course_class_feedback_requests', $course_class_feedback_requests)
                    ->with('current_semester',$current_semester)
                    ->with('timeObj',$timeObj);
    }

    public function processJoinOnlineLecture(Request $request, $id, $lectureId)
    {
        $current_user = Auth()->user();
        $courseClass = $this->courseClassRepository->find($id);
        $lectureMaterial = $this->classMaterialRepository->find($lectureId);

        $displayName = "{$current_user->name}";

        if ($current_user->lecturer_id!=null)
        {
            $password = 'PW$$moderator';
        }

        if($current_user->student_id != null)
        {
            $password = 'PW$$attendee';
        }

        $meetingID = $lectureMaterial->blackboard_meeting_id;
        $name = $displayName;
        $bbb = new BigBlueButton();
        $bbb_join = new JoinMeetingParameters($meetingID, $name, $password);
        $bbb_join->setRedirect(true);
        $url = $bbb->getJoinMeetingURL($bbb_join);

        if(empty($url))
        {
            return redirect()->route('dashboard.class',$id);
        }

        return redirect($url);
           
    }

    public function processStudentAttendanceDetails(Request $request, $course_class_id, $lectureId)
    {
        $current_user = Auth()->user();
        
        $lecture_photo = null;

        $captured_image = $request->student_img;  // base64 encoded
        $captured_image = str_replace('data:image/jpeg;base64,', '', $captured_image);
        $captured_image = str_replace(' ', '+', $captured_image);
        $captured_image_name = time(). '.jpeg';       
        $storagePath = public_path('uploads/'.$captured_image_name);
        file_put_contents($storagePath, base64_decode($captured_image));

        $input = [
            'student_id' => $current_user->student_id,
            'course_class_id' => $course_class_id,
            'class_material_id' => $lectureId,
            'photo_file_path' => $storagePath,
        ];

        $check_attendance_existence = StudentAttendance::where('course_class_id',$course_class_id)->where('class_material_id',$lectureId)->where('student_id',$current_user->student_id)->first();
        if(!empty($check_attendance_existence)){
            File::delete($check_attendance_existence->photo_file_path);
            $lecture_photo = StudentAttendance::find($check_attendance_existence->id);
            $lecture_photo->fill($input);
            $lecture_photo->save();
        }else{
             //Upload Captured Image  
            $lecture_photo = new StudentAttendance();        
            $lecture_photo->student_id = $current_user->student_id;
            $lecture_photo->course_class_id = $course_class_id;
            $lecture_photo->class_material_id = $lectureId;
            if(empty($request->student_img))
            {
                $lecture_photo->photo_file_path = $request->photo_file_path;
            }else{
                $lecture_photo->photo_file_path = $storagePath;
            }    
            $lecture_photo->save(); 
         }    
          return true;
    }

    public function processEndOnlineLecture(Request $request, $id, $lectureId)
    {
        $current_user = Auth()->user();
        $courseClass = $this->courseClassRepository->find($id);  
        $lectureMaterial = $this->classMaterialRepository->find($lectureId);      

        $this->classMaterialRepository->update(
            ['blackboard_meeting_status' => "ended"],
            $lectureId
        );

        $meetingID = $lectureMaterial->blackboard_meeting_id;
        $moderator_password = 'PW$$moderator';
        $bbb = new BigBlueButton();
        $bbb_end = new EndMeetingParameters($meetingID, $moderator_password);
        $response = $bbb->endMeeting($bbb_end);

        return redirect()->route('dashboard.class',$id)->with('message', $response->getMessage());
    }

    public function processRecordingOnlineLecture(Request $request, $id, $lectureId)
    {
        $current_user = Auth()->user();
        $courseClass = $this->courseClassRepository->find($id);
        $lectureMaterial = $this->classMaterialRepository->find($lectureId);
        $recordingUrl = "";

        $bbb = new BigBlueButton();
        $meetingID = optional($lectureMaterial)->blackboard_meeting_id;
        $bbb_get_recordings = new GetRecordingsParameters();
        $bbb_get_recordings->setMeetingId($meetingID);
        $response = $bbb->getRecordings($bbb_get_recordings);  
        
        if($response->getReturnCode() == 'SUCCESS')
        {
            foreach($response->getRawXml()->recordings->recording as $recording) 
            {
                if ($recording->meetingID == $meetingID) 
                {
                   $recordingUrl = $recording->playback->format->url;
                   break;
                }

                if ($recordingUrl != null)
                {
                    $this->classMaterialRepository->update([   
                        'blackboard_meeting_status' => "video-available",
                        'reference_material_url' => $recordingUrl
                        ], $lectureId);
                }
            }
            if($recordingUrl) 
            {
                return redirect($recordingUrl);
            }

        }else{
            return back()->withErrors(['msg', 'Recording not Found.']);
        }
    }

    public function processStartOnlineLecture(Request $request, $id, $lectureId)
    {
        $current_user = Auth()->user();
        $courseClass = $this->courseClassRepository->find($id);
        $lectureMaterial = $this->classMaterialRepository->find($lectureId);
        $Uuid = Str::orderedUuid()->toString();

        $bbb = new BigBlueButton();
        if ($bbb){
            $meetingID = $Uuid; //Meeting ID must be unique to prevent simultaneous meetings with same ID;
            $lecture_material = $this->classMaterialRepository->update([
                'blackboard_meeting_id' => $meetingID,
                'blackboard_meeting_status' => "in-progress",
                'course_class_id' => $id
            ], $lectureId);

            $meetingName = $lectureMaterial->title;
            $attendee_password= 'PW$$attendee';
            $moderator_password = 'PW$$moderator';
            $isRecordingTrue = true;
            $endCallBackUrl = route('dashboard.class.end-lecture', [$id, $lecture_material->id]);
            $recordingReadyCallbackUrl = route('dashboard.class.record-lecture', [$id, $lecture_material->id]);
            
            $bbb_room = new CreateMeetingParameters($meetingID, $meetingName);
            $bbb_room->setAttendeePassword($attendee_password);
            $bbb_room->setModeratorPassword($moderator_password);
            $bbb_room->setEndCallbackUrl($endCallBackUrl);
            $bbb_room->setRecordingReadyCallbackURL($recordingReadyCallbackUrl);

            if($isRecordingTrue) 
            {
                $bbb_room->setRecord(true);
                $bbb_room->setAllowStartStopRecording(true);
                $bbb_room->setAutoStartRecording(true);
            }

            $response = $bbb->createMeeting($bbb_room);

            if($response->getReturnCode() == 'SUCCESS')
            {
                if($current_user->lecturer_id != null)
                {
                    return redirect()->route('dashboard.class.join-lecture',[$id,$lecture_material->id]);
                }
            }
            return redirect()->route('dashboard.class',$id)->with('message', $response->getMessage());
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
       

        $submissions =  $this->submissionRepository->all(['course_class_id'=>$course_class_id,'class_material_id'=>$class_material_id]);

        $grades = $this->gradeRepository->all(['course_class_id'=>$course_class_id,'class_material_id'=>$class_material_id]);
       

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
                    ->with('grades', $grades)
                    ->with('submissions', $submissions);
    }

    public function listOfRespondedFeebacks(Request $request, $course_class_id, $course_class_feedback_id){

        $current_user = Auth()->user();
        $courseClass = CourseClass::find($course_class_id);
        $courseFeedback = CourseClassFeedback::find($course_class_feedback_id);
        $course_class_feedback_responses = CourseClassFeedbackResponse::where('course_class_id', $courseClass->id)->where('course_class_feedback_id', $courseFeedback->id)->count();
        $feedback_responses = CourseClassFeedbackResponse::all();
        $students = Student::all();
        $feedback_requests = CourseClassFeedback::find($course_class_feedback_id);

        return view("dashboard.class.student_feedbacks")
        ->with('courseClass', $courseClass)
        ->with('current_user', $current_user)
        ->with('feedback_requests', $feedback_requests)
        ->with('feedback_responses', $feedback_responses)
        ->with('students', $students)
        ->with('courseFeedback', $courseFeedback)
        ->with('course_class_feedback_responses', $course_class_feedback_responses);
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
                                    Submission::where([['student_id',$grade_query['student_id']],
                                                        ['course_class_id',$grade_query['course_class_id']],
                                                        ['class_material_id',$grade_query['class_material_id']],
                                                        ])
                                                        ->update(['grade_id' => $grade_model->id]);
                                }
                            } else {
                                //Create a new grade since one doesn't exist.
                               $grade = $this->gradeRepository->create($grade_query);
                                Submission::where([['student_id',$grade_query['student_id']],
                                ['course_class_id',$grade_query['course_class_id']],
                                ['class_material_id',$grade_query['class_material_id']],
                                ])
                                ->update(['grade_id' => $grade->id]);
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

                $final_scores["fs-{$grade->student_id}"] = $final_score;   

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

    public function getStudentSubmission($classMaterialId, $studentId)
    {
        $submission = Submission::where('class_material_id', $classMaterialId)->where('student_id', $studentId)->first();

        $submission_data = [];
        
        if ($submission) {
            $submission_data = [
                'id'           => $submission->id,
                'student_name' => $submission->student->first_name.' '.$submission->student->last_name,
                'comment'      => $submission->comment
            ];
            return response()->json(['found'=>true, 'submission'=>$submission_data]);
        }
        return response()->json(['found'=>false, 'submission'=>$submission_data]);
    }
    
    public function processLecturerComment(GradeCommentRequest $request)
    {
        // save comment
        $submission = Submission::find($request->submission_id);
        $submission->comment = $request->comment;
        $submission->save();

        //update grade
        $grade = Grade::where('student_id', $submission->student_id)
                        ->where('class_material_id', $submission->class_material_id)
                        ->where('course_class_id', $submission->course_class_id)
                        ->first();
        if ($grade) {
            $grade->score = $request->score;
            $grade->save();
        }
        return true;
    }

    public function printAttendanceList(Request $request,$course_class_id,$class_material_id)
    {
        $course_class = CourseClass::find($course_class_id);

        $current_semester = $this->semesterRepository->all(['is_current'=>true])->first();

        $lecture = ClassMaterial::where('type','lecture-classes')
                                ->where('semester_id',$current_semester->id)
                                ->find($class_material_id);

        $attendances = StudentAttendance::where('course_class_id',$course_class->id)
                                    ->where('class_material_id', $lecture->id)->get();

        return view('dashboard.class.partials.attendance')
               ->with('course_class',$course_class)
               ->with('attendances',$attendances);
    }
}

?>