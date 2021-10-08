<?php

namespace App\Managers;

use App\Repositories\GradeRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubmissionRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\CourseClassRepository;
use App\Repositories\ClassMaterialRepository;


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
    private $assignmentList;
    private $examinationList;
    
    public function __construct($courseClassId)
    {
        $this->classMaterialRepository = new ClassMaterialRepository(app());
        $this->courseClassRepository = new CourseClassRepository(app());
        $this->submissionRepository = new SubmissionRepository(app());
 
        $this->courseClass = $this->courseClassRepository->find($courseClassId);
        $this->classAssignments = $this->classMaterialRepository->all(['course_class_id'=>$courseClassId,'type'=>'class-assignments']);
        $this->classExaminations = $this->classMaterialRepository->all(['course_class_id'=>$courseClassId,'type'=>'class-examinations']);
        
        $this->assignmentList = array();
        $this->examinationList = array();

    }
    
    private function build_activity_map(){
        
        $studentClassActivity = DB::table('student_class_activities')
        ->join('class_materials','student_class_activities.class_material_id', '=','class_materials.id')
        ->join('students','student_class_activities.student_id','=','students.id')
        ->select('student_class_activities.*','students.last_name','students.first_name','students.matriculation_number',
        DB::raw("sum(case when student_class_activities.downloaded = 1 then 1 end) as noOfDownloads"),
        DB::raw("sum(case when class_materials.type = 'lecture-classes' and (student_class_activities.clicked = 1 or student_class_activities.downloaded = 1) then 1 end) as lectureMaterialClick"),
        DB::raw("sum(case when class_materials.type = 'class-assignments' and (student_class_activities.clicked = 1 or student_class_activities.downloaded = 1) then 1 end) as assignmentMaterialClick"),
        DB::raw("sum(case when class_materials.type = 'reading-materials' and (student_class_activities.clicked = 1 or student_class_activities.downloaded = 1) then 1 end) readingMaterialClick"))
        ->where('student_class_activities.course_class_id',$course_class)
        ->groupBy(['student_class_activities.student_id'])->get();

        $studentDiscussions = Forum::select('student_id',DB::raw("count(parent_forum_id) as studentDiscussion"))->where([['course_class_id',$course_class],['parent_forum_id','!=',null]])->groupBy('student_id')->get();
    

        foreach($enrollments as $key => $value){
            $studentClassActivityMatch = $studentClassActivity->firstWhere('student_id', '=',$value->student_id);
            $discussionActivityMatch = $studentDiscussions->firstWhere('student_id', '=',$value->student_id);
            if( $studentClassActivityMatch != null){
                $enrolledStudentClassActivity[$key] = [
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
        
    }

    public function get_map(){
        return $this->activityMap;
    }

    public function get_assignment_list(){
        return $this->assignmentList;
    }

    public function get_examination_list(){
        return $this->examinationList;
    }

    public static function get_activity_score($courseClassId, $student_matric){

        // For a particular student
        // LOW or MODERATE or HIGH
        // score for the main dimensions .. reading material, discussions, assignments, lectures
        // then an overall participation score

    }

}


?>