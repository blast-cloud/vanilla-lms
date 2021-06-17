<?php

namespace App\Http\Controllers\FrontEnd;


use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\CreateLecturerRequest;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

use App\Models\User;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Department;

use App\Events\StudentCreated;
use App\Events\LecturerCreated;
use App\Repositories\StudentRepository;
use App\Repositories\LecturerRepository;

use Illuminate\Http\Request;

class FrontEndController extends AppBaseController
{

    /** @var  StudentRepository */
    private $studentRepository;

    /** @var  LecturerRepository */
    private $lecturerRepository;

    public function __construct(LecturerRepository $lecturerRepo, StudentRepository $studentRepo)
    {
        $this->lecturerRepository = $lecturerRepo;
        $this->studentRepository = $studentRepo;

        parent::__construct();
    }

    /**
     * Show the frontend home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('welcome');
    }

    /**
     * Show the student registration page.
     *
     * @return \Illuminate\Http\Response
     */
    public function displayStudentRegistration(Request $request)
    {
        if (isset($this->app_settings['cbx_allow_student_registration'])==false || $this->app_settings['cbx_allow_student_registration']!=1) {
            return abort(404);
        }

        $departmentItems = \App\Models\Department::pluck('name','id')->toArray();

        return view('student-register')
                ->with("departmentItems", $departmentItems);
                
    }


    /**
     * Show the lecturer registration page.
     *
     * @return \Illuminate\Http\Response
     */
    public function displayLecturerRegistration(Request $request)
    {
        if (isset($this->app_settings['cbx_allow_lecturer_registration'])==false || $this->app_settings['cbx_allow_lecturer_registration']!=1) {
            return abort(404);
        }

        $departmentItems = \App\Models\Department::pluck('name','id')->toArray();

        return view('lecturer-register')
                ->with("departmentItems", $departmentItems);

    }


    /**
     * Process the lecturer registration.
     *
     * @return \Illuminate\Http\Response
     */
    public function processLecturerRegistration(CreateLecturerRequest $request)
    {
        if (isset($this->app_settings['cbx_allow_lecturer_registration'])==false || $this->app_settings['cbx_allow_lecturer_registration']!=1) {
            return abort(404);
        }

        $input = $request->all();
        $lecturer = $this->lecturerRepository->create($input);
        LecturerCreated::dispatch($lecturer);

        return redirect()->route('login')->with('success','You have been successfully registered. Please check your email for your login credentials to access the portal.');
    }

    /**
     * Process the student registration.
     *
     * @return \Illuminate\Http\Response
     */
    public function processStudentRegistration(CreateStudentRequest $request)
    {
        if (isset($this->app_settings['cbx_allow_student_registration'])==false || $this->app_settings['cbx_allow_student_registration']!=1) {
            return abort(404);
        }

        $input = $request->all();
        $student = $this->studentRepository->create($input);
        StudentCreated::dispatch($student);

        return redirect()->route('login')->with('success','You have been successfully registered. Please check your email for your login credentials to access the portal.');
    }



}
