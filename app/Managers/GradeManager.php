<?php

namespace App\Managers;

use App\Repositories\GradeRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubmissionRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\CourseClassRepository;
use App\Repositories\ClassMaterialRepository;


class GradeManager{

    /** @var  CourseClassRepository */
    private $courseClassRepository;

    /** @var  ClassMaterialRepository */
    private $classMaterialRepository;

    /** @var  EnrollmentRepository */
    private $enrollmentRepository;

    /** @var  SubmissionRepository */
    private $submissionRepository;

    /** @var  GradeRepository */
    private $gradeRepository;

    private $finalGrades;
    private $enrollments;
    private $courseClass;
    private $classAssignments;
    private $classExaminations;
    private $gradeMap;
    private $assignmentList;
    private $examinationList;
    
    public function __construct($courseClassId)
    {
        $this->classMaterialRepository = new ClassMaterialRepository(app());
        $this->courseClassRepository = new CourseClassRepository(app());
        $this->enrollmentRepository = new EnrollmentRepository(app());
        $this->submissionRepository = new SubmissionRepository(app());
        $this->gradeRepository = new GradeRepository(app());

        $this->courseClass = $this->courseClassRepository->find($courseClassId);
        $this->classAssignments = $this->classMaterialRepository->all(['course_class_id'=>$courseClassId,'type'=>'class-assignments']);
        $this->classExaminations = $this->classMaterialRepository->all(['course_class_id'=>$courseClassId,'type'=>'class-examinations']);
        
        $this->finalGrades = $this->gradeRepository->all(['course_class_id'=>$courseClassId, 'class_material_id'=>null]);
        $this->enrollments = $this->enrollmentRepository->all(['course_class_id'=>$courseClassId]);

        $this->gradeMap = array();
        $this->assignmentList = array();
        $this->examinationList = array();

        $this->build_grade_map();
    }
    
    private function build_grade_map(){
        foreach($this->enrollments as $idx=>$enrollment){

            $this->gradeMap[$enrollment->student->id] = array(
                'name'=>$enrollment->student->getFullName(),
                'student_id'=>$enrollment->student->id,
                'matric_num'=>$enrollment->student->matriculation_number,
                'assignments'=>[],
                'examinations'=>[],
            );

            foreach($this->classAssignments as $idx=>$assignment){
                $this->assignmentList["assignment-{$assignment->id}"]=$assignment;

                $assignment_grade = $this->gradeRepository->first([
                    'student_id'=>$enrollment->student->id, 
                    'course_class_id'=>$enrollment->course_class_id, 
                    'class_material_id'=>$assignment->id
                ]);

                $this->gradeMap[$enrollment->student->id]['assignments']["assignment-{$assignment->id}"] = array(
                    'has_score'=>$assignment_grade!=null,
                    'grade'=>$assignment_grade,
                    'class_material_id' => $assignment->id,
                    'score'=>$assignment_grade!=null?$assignment_grade->score:null,
                    'max_points'=>$assignment->grade_max_points,
                    'label'=>"Assignment {$assignment->assignment_number}",
                    'grade_contribution_pct'=>$assignment->grade_contribution_pct
                );
                $grade_score = $assignment_grade!=null?$assignment_grade->score:0;
                $current_score = 0;
                if(isset($this->gradeMap[$enrollment->student->id]['assignments']['total-score'])){
                    $current_score = $this->gradeMap[$enrollment->student->id]['assignments']['total-score'];          
                }else{
                    $current_score  = 0 ;
                }
                $this->gradeMap[$enrollment->student->id]['assignments']['total-score'] =  $current_score + $grade_score;
               
            }
    
            foreach($this->classExaminations as $idx=>$examination){
                $this->examinationList["examination-{$examination->id}"] = $examination;

                $examination_grade = $this->gradeRepository->first([
                    'student_id'=>$enrollment->student->id, 
                    'course_class_id'=>$enrollment->course_class_id, 
                    'class_material_id'=>$examination->id
                ]);

                $this->gradeMap[$enrollment->student->id]['examinations']["examination-{$examination->id}"] = array(
                    'has_score'=>$examination_grade!=null,
                    'grade'=>$examination_grade,
                    'score'=>$examination_grade!=null?$examination_grade->score:null,
                    'max_points'=>$examination->grade_max_points,
                    'label'=>"Exam {$examination->examination_number}",
                    'grade_contribution_pct'=>$examination->grade_contribution_pct
                );
            }

            foreach($this->finalGrades as $idx=>$grade){
                if ($grade->student->id == $enrollment->student->id){
                    $this->gradeMap[$enrollment->student->id]["final-grade"] = $grade;
                }
            }
        }
    }

    public function get_map(){
        return $this->gradeMap;
    }

    public function get_assignment_list(){
        return $this->assignmentList;
    }

    public function get_examination_list(){
        return $this->examinationList;
    }

    public static function computeFinalScore($courseClassId, $student_matric){

        $final_score = 0;

        $classMaterialRepository = new ClassMaterialRepository(app());
        $courseClassRepository = new CourseClassRepository(app());
        $enrollmentRepository = new EnrollmentRepository(app());
        $studentRepository = new StudentRepository(app());
        $gradeRepository = new GradeRepository(app());

        //Find student by matric number.
        $student = $studentRepository->first(['matriculation_number'=>$student_matric]);

        if ($student != null){
            //Ensure student is enrolled in course
            $enrollment = $enrollmentRepository->first(['course_class_id'=>$courseClassId,'student_id'=>$student->id]);
            if ($enrollment != null){

                //get assignments
                $classAssignments = $classMaterialRepository->all(['course_class_id'=>$courseClassId,'type'=>'class-assignments']);
                foreach($classAssignments as $assignment){
                    //get grade
                    $grade = $gradeRepository->first(['course_class_id'=>$courseClassId, 'student_id'=>$student->id, 'class_material_id'=>$assignment->id]);
                    if ($grade != null){
                        $final_score += (($grade->score/$assignment->grade_max_points) * $assignment->grade_contribution_pct);
                    }
                }

                //get exams
                $classExaminations = $classMaterialRepository->all(['course_class_id'=>$courseClassId,'type'=>'class-examinations']);
                foreach($classExaminations as $examination){
                    //get grade
                    $grade = $gradeRepository->first(['course_class_id'=>$courseClassId, 'student_id'=>$student->id, 'class_material_id'=>$examination->id]);
                    if ($grade != null){
                        $final_score += (($grade->score/$examination->grade_max_points) * $examination->grade_contribution_pct);
                    }
                }
                
            }
        }

        return $final_score;
    }

    public function get_assignments_max_scores(){
        return $this->classAssignments->sum('grade_max_points');
    }

}


?>