<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Log;
use Flash;
use App\Managers\GradeManager;
use App\Http\Controllers\AppBaseController;

use App\Repositories\DepartmentRepository;
use App\Repositories\CourseClassRepository;
use App\Repositories\ClassMaterialRepository;
use App\Repositories\EnrollmentRepository;

use Carbon\Carbon;
use Response;
use Illuminate\Http\Request;

class GradeExport implements FromView
{

    private $department;
    private $courseClass;
    private $enrollments;
    private $current_user;
    private $gradeManager;
    private $class_assignments;
    private $class_examinations;

    public function __construct(DepartmentRepository $departmentRepo, 
                                CourseClassRepository $courseClassRepo, 
                                ClassMaterialRepository $classMaterialRepo,
                                EnrollmentRepository $enrollmentRepo,
                                $course_class_id){

        $this->current_user = Auth()->user();
        $this->department = $departmentRepo->find($this->current_user->department_id);
        $this->courseClass = $courseClassRepo->find($course_class_id);

        $this->class_assignments = $classMaterialRepo->all(['course_class_id'=>$course_class_id,'type'=>'class-assignments']);
        $this->class_examinations = $classMaterialRepo->all(['course_class_id'=>$course_class_id,'type'=>'class-examinations']);

        $this->enrollments = $enrollmentRepo->all(['course_class_id'=>$course_class_id]);

        if ($this->courseClass!=null && $this->courseClass->lecturer_id == $this->current_user->lecturer_id){
            $this->gradeManager = new GradeManager($course_class_id);
        }
    }


    public function view(): View
    {
        return view('dashboard.class.grade-export', [
            'department' => $this->department,
            'courseClass' => $this->courseClass,
            'current_user'=> $this->current_user,
            'class_assignments' => $this->class_assignments,
            'class_examinations' => $this->class_examinations,
            'gradeManager' => $this->gradeManager,
            'enrollments' => $this->enrollments,
        ]);
    }
}