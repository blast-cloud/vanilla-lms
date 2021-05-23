<?php

namespace App\Managers;

use App\Repositories\GradeRepository;
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
                $this->gradeMap[$enrollment->student->id]['assignments']["assignment-{$assignment->id}"] = array(
                    'has_score'=>false,
                    'grade'=>null,
                    'score'=>0,
                    'max_points'=>$assignment->grade_max_points,
                    'grade_contribution_pct'=>$assignment->grade_contribution_pct
                );
            }
    
            foreach($this->classExaminations as $idx=>$examination){
                $this->examinationList["examination-{$examination->id}"] = $examination;
                $this->gradeMap[$enrollment->student->id]['examinations']["examination-{$examination->id}"] = array(
                    'has_score'=>false,
                    'grade'=>null,
                    'score'=>0,
                    'max_points'=>$examination->grade_max_points,
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

}


?>