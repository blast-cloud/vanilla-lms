<?php

namespace App\Managers;

use App\Repositories\GradeRepository;
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

    /** @var  GradeRepository */
    private $gradeRepository;

    private $finalGrades;
    private $enrollments;
    private $courseClass;
    private $classAssignments;
    private $classExaminations;
    private $gradeMap;
    
    public function __construct($courseClassId)
    {
        $this->courseClassRepository = new CourseClassRepository(app());
        $this->classMaterialRepository = new ClassMaterialRepository(app());
        $this->enrollmentRepository = new EnrollmentRepository(app());
        $this->gradeRepository = new GradeRepository(app());

        $this->courseClass = $this->courseClassRepository->find($courseClassId);
        $this->classAssignments = $this->classMaterialRepository->all(['course_class_id'=>$courseClassId,'type'=>'class-assignments']);
        $this->classExaminations = $this->classMaterialRepository->all(['course_class_id'=>$courseClassId,'type'=>'class-examinations']);
        
        $this->finalGrades = $this->gradeRepository->all(['course_class_id'=>$courseClassId, 'class_material_id'=>null]);
        $this->enrollments = $this->enrollmentRepository->all(['course_class_id'=>$courseClassId]);

        $this->gradeMap = array();

        $this->build_grade_map();
    }
    
    private function build_grade_map(){
        foreach($this->enrollments as $idx=>$enrollment){

            $this->gradeMap[$enrollment->student->id] = array(
                'name'=>$enrollment->student->getFullName(),
                'student_id'=>$enrollment->student->id,
                'matric_num'=>$enrollment->student->matriculation_number
            );

            foreach($this->classAssignments as $idx=>$assignment){
                $this->gradeMap[$enrollment->student->id]["assignment-{$assignment->id}"] = null;
            }
    
            foreach($this->classExaminations as $idx=>$examination){
                $this->gradeMap[$enrollment->student->id]["examination-{$examination->id}"] = null;
            }

            foreach($this->finalGrades as $idx=>$grade){
                if ($grade->student->id == $enrollment->student->id){
                    $this->gradeMap[$enrollment->student->id]["final-grade"] = $grade;
                }
            }
        }
    }

}


?>