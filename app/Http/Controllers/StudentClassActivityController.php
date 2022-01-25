<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests;
use App\Repositories\StudentClassActivityRepository;
use App\Models\StudentClassActivity;
use Response;


class StudentClassActivityController extends Controller
{
    //
    public $studentClassActivityRepository;
    public function __construct(StudentClassActivityRepository $studentClassActivityRepo){
        $this->studentClassActivityRepository = $studentClassActivityRepo;
    }
    public function index(){
        
    }
    public function create(Request $request){
        
    }
    public function edit(){
       
    }
    public function store(Request $request){

        $result = 0 ;
        $student_activity = null;
        if($request->downloaded == '1'){
           $query = $this->studentClassActivityRepository->first(['student_id' => $request->student_id,'class_material_id' => $request->class_material_id, 'course_class_id' => $request->course_class_id, 'downloaded' => true]);
            if(!empty($query)){
                $student_activity = $query;
                $result = 1;
             }
        }
        if ($request->clicked == '1') {
             $query = $this->studentClassActivityRepository->first(['student_id' => $request->student_id,'class_material_id' => $request->class_material_id, 'course_class_id' => $request->course_class_id,'clicked' => true]);
             if(!empty($query)){
                $student_activity = $query;
                $result = 1;
             }

        }
        if($result == 0){
            $student_activity = $this->studentClassActivityRepository->create($request->all());
        }
       
        return response()->json($student_activity);
    }
    public function update(Request $request){
          
    }
}
