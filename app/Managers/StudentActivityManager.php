<?php

namespace App\Managers;

use App\Repositories\GradeRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubmissionRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\CourseClassRepository;
use App\Repositories\ClassMaterialRepository;
use App\Repositories\SemesterRepository;
use App\Repositories\SettingRepository;

use App\Models\Forum;
use App\Models\ClassMaterial;
use App\Models\StudentClassActivity;
use DB;
use Illuminate\Support\Collection;


class StudentActivityManager{

    /** @var  CourseClassRepository */
    private $courseClassRepository;

    /** @var  ClassMaterialRepository */
    private $classMaterialRepository;

    /** @var  SubmissionRepository */
    private $submissionRepository;

    private $courseClass;
    private $classAssignments;
    private $classExaminations;
    private $classReadingMaterials;
    private $classLectures;
    private $assignmentList;
    private $examinationList;
    private $studentClassActivity;
    private $enrollments;
    private $lectureNotes;
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
    

    public function __construct($courseClassId)
    {
        $this->classMaterialRepository = new ClassMaterialRepository(app());
        $this->courseClassRepository = new CourseClassRepository(app());
        $this->submissionRepository = new SubmissionRepository(app());
        $this->semesterRepository =  new SemesterRepository(app());
        $this->enrollmentRepository =  new EnrollmentRepository(app());
        $this->settingRepository = new SettingRepository(app());
        $this->enrollments = $this->enrollmentRepository->all(['course_class_id'=>$courseClassId]);
        $this->assignmentList = array();
        $this->examinationList = array();
        $this->get_artifacts($courseClassId);
        $this->get_studentClassActivity($courseClassId);

    }
    private function get_artifacts($id){
        
        $this->courseClass = $this->courseClassRepository->find($id);
        $current_semester =$this->semesterRepository->all(['is_current'=>true])->first();
        $this->lectureNotes = ClassMaterial::where([['course_class_id',$id],['type','lecture-notes'],['semester_id',$current_semester->id]])->get();
        $this->classReadingMaterials = ClassMaterial::where([['course_class_id',$id],['type','reading-materials'],['semester_id',$current_semester->id]])->get();
        $this->classAssignments = ClassMaterial::where([['course_class_id',$id],['type','class-assignments'],['semester_id',$current_semester->id]])->get();
        $this->classExaminations = ClassMaterial::where([['course_class_id',$id],['type','class-examinations'],['semester_id',$current_semester->id]])->get();
        $this->classLectures = ClassMaterial::where([['course_class_id',$id],['type','lecture-classes'],['semester_id',$current_semester->id]])->get();
    }
    private function get_studentClassActivity($courseClassId){
        $this->studentClassActivity =  DB::table('student_class_activities')
        ->join('class_materials','student_class_activities.class_material_id', '=','class_materials.id')
        ->join('students','student_class_activities.student_id','=','students.id')
        ->select('student_class_activities.*','students.last_name','students.first_name','students.matriculation_number',
        DB::raw("sum(case when student_class_activities.downloaded = 1 then 1 end) as noOfDownloads"),
        DB::raw("sum(case when class_materials.type = 'lecture-classes' and (student_class_activities.clicked = 1 or student_class_activities.downloaded = 1) then 1 end) as lectureMaterialClick"),
        DB::raw("sum(case when class_materials.type = 'class-assignments' and (student_class_activities.clicked = 1 or student_class_activities.downloaded = 1) then 1 end) as assignmentMaterialClick"),
        DB::raw("sum(case when class_materials.type = 'reading-materials' and (student_class_activities.clicked = 1 or student_class_activities.downloaded = 1) then 1 end) readingMaterialClick"))
        ->where('student_class_activities.course_class_id',$courseClassId)
        ->groupBy(['student_class_activities.student_id'])->get();
        

    }
    private function build_activity_map(){
        
        $enrolledStudentClassActivity = []; 

        $studentDiscussions = Forum::select('student_id',DB::raw("count(parent_forum_id) as studentDiscussion"))->where([['course_class_id',$this->courseClass->id],['parent_forum_id','!=',null]])->groupBy('student_id')->get();

        foreach($this->enrollments as $key => $value){
            $studentClassActivityMatch = $this->studentClassActivity->firstWhere('student_id', '=',$value->student_id);
            $discussionActivityMatch = $studentDiscussions->firstWhere('student_id', '=',$value->student_id);
            if( $studentClassActivityMatch != null){
                $enrolledStudentClassActivity[$key] = [
                    'student_id' => $value->student->id,
                    'first_name' => $value->student->first_name,
                    'last_name' => $value->student->last_name,
                    'matriculation_number' =>  $value->student->matriculation_number,
                    'assignmentClick' =>  $studentClassActivityMatch->assignmentMaterialClick,
                    'lectureMaterialClick' =>  $studentClassActivityMatch->lectureMaterialClick,
                    'readingMaterialClick' =>  $studentClassActivityMatch->readingMaterialClick,
                    'discussion' => ($discussionActivityMatch != null) ? $discussionActivityMatch->studentDiscussion : null,
            ];
            }
            else{
              
                $enrolledStudentClassActivity[$key]=[
                    'student_id' => $value->student->id,
                    'first_name' => $value->student->first_name,
                    'last_name' => $value->student->last_name,
                    'matriculation_number' =>  $value->student->matriculation_number,
                    'assignmentClick' => null,
                    'lectureMaterialClick' => null,
                    'readingMaterialClick' => null,
                    'discussion' => ($discussionActivityMatch != null) ? $discussionActivityMatch->studentDiscussion : null,
                ];
            }
            
        }
        return  $enrolledStudentClassActivity;
        
    }

    public function get_map(){
        return $this->build_activity_map();
    }

    public function get_assignment_list(){
        return $this->assignmentList;
    }
    public function get_reading_materials(){
        return $this->classReadingMaterials;
    }
    public function get_class_lectures(){
        return $this->classLectures;
    }
    public function get_class_assignment(){
        return $this->classAssignments;
    }
    public function get_examination(){
        return $this->classExaminations;
    }
    public function get_lecture_note(){
        return $this->lectureNotes;
    }
    

    public function get_activity_score($courseClassId, $student_id){
      $this->__construct($courseClassId);
        $enrolledStudentClassActivity = $this->build_activity_map();
        $readingMaterialCount = count($this->classReadingMaterials);
        $lectureMaterialCount = count($this->classLectures);
        $assignmentMaterialCount = count($this->classAssignments);

        $totalObtainable =  $assignmentMaterialCount + $readingMaterialCount + $lectureMaterialCount ;
        $obtainableAverage = $totalObtainable / 2;
        $message;
        $key = array_search($student_id, array_column($enrolledStudentClassActivity, 'student_id'));
        $totalStudentActivity = $enrolledStudentClassActivity[$key]['assignmentClick'] + $enrolledStudentClassActivity[$key]['lectureMaterialClick'] + $enrolledStudentClassActivity[$key]['readingMaterialClick'] + $enrolledStudentClassActivity[$key]['discussion'];

        if(($totalStudentActivity >= $obtainableAverage) && ($totalStudentActivity <= ($obtainableAverage + (round($obtainableAverage * 1/3))))){
            $message = 'moderate';
        }
        if(($totalStudentActivity < $obtainableAverage) && $totalStudentActivity > 0){
            $message = 'low';
        }
        if(($totalStudentActivity >= $obtainableAverage) && ($totalStudentActivity >= ($obtainableAverage + (round($obtainableAverage * 1/3))))){
            $message= 'high';
        }
        if($totalStudentActivity == 0){
            $message = null;
        }
        

        return $message;
        
    }

    public function getAppSettings(){
        $db_settings = $this->settingRepository
        ->allWhereInQuery(['key'=>$this->setting_keys],null,100)
        ->pluck('value','key')
        ->toArray();
        
        return $db_settings;
    }

}


?>