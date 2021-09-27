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
        $result = $this->studentClassActivityRepository->create($request->all());
        return response()->json($result);
    }
    public function update(Request $request){
          
    }
}
