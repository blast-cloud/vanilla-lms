<?php

namespace App\Http\Controllers;

use App\DataTables\AnnouncementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Repositories\AnnouncementRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CourseClassRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\LecturerRepository;
use App\Repositories\ManagerRepository;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends AppBaseController
{

    /** @var  ManagerRepository */
    private $managerRepository;

    /** @var  StudentRepository */
    private $studentRepository;

    /** @var  LecturerRepository */
    private $lecturerRepository;

    /** @var  CourseClassRepository */
    private $courseClassRepo;

    /** @var  EnrollmentRepository */
    private $enrollmentRepo;

    public function __construct(LecturerRepository $lecturerRepository, 
                                    ManagerRepository $managerRepository, 
                                    StudentRepository $studentRepository,
                                    CourseClassRepository $courseClassRepo, 
                                    EnrollmentRepository $enrollmentRepo)
    {
        $this->studentRepository = $studentRepository;
        $this->managerRepository = $managerRepository;
        $this->lecturerRepository = $lecturerRepository;
        $this->enrollmentRepo = $enrollmentRepo;
        $this->courseClassRepo = $courseClassRepo;
    }
    

    public function displayProfile(Request $request){
        $current_user = Auth()->user();

        $matric_num = "";
        $first_name = "System";
        $last_name = "Administrator";
        $class_schedules = [];

        if ($current_user->manager_id != null){
            $class_schedules = $this->courseClassRepo->all(['department_id'=>$current_user->department_id]);
            $first_name = $current_user->manager->first_name;
            $last_name = $current_user->manager->last_name;

        }else if ($current_user->student_id != null){

            $enrollment_ids = [];
            $enrollments = $this->enrollmentRepo->all(['student_id'=>$current_user->student_id]);
            foreach ($enrollments as $item){
                $enrollment_ids []= $item->course_class_id;
            }
            $class_schedules = $this->courseClassRepo->findMany($enrollment_ids);

            $matric_num = $current_user->student->matriculation_number;
            $first_name = $current_user->student->first_name;
            $last_name = $current_user->student->last_name;
    
        }else if ($current_user->lecturer_id != null){
            $class_schedules = $this->courseClassRepo->all(['lecturer_id'=>$current_user->lecturer_id]);
            $first_name = $current_user->lecturer->first_name;
            $last_name = $current_user->lecturer->last_name;
        }

        return view("auth.profile")
                ->with("last_name", $last_name)
                ->with("first_name", $first_name)
                ->with("matric_num", $matric_num)
                ->with("current_user", $current_user)
                ->with('class_schedules', $class_schedules);
    }

    protected function validateUserDetails(Request $request)
    {
        $current_user = Auth()->user();

        $validation_rules = array(
            'email' => "required|email|string|max:255|unique:users,email,{$current_user->id}",
            'telephone' => "required|numeric|digits:11|unique:users,telephone,{$current_user->id}",
            'password' => 'nullable|string|min:8|confirmed|regex:/^(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',            
        );

        $validation_messages = array(
            'required' => 'The :attribute field is required.',
            'regex' => 'The :attribute field has to include at least a number, text and a character'
        );

        $attributes = array(
            'password' => 'Password',
            'telephone' => 'Phone Number',
            'email' => 'Email Address'
        );

        //Create a validator for the data in the request
        $validator = Validator::make($request->all(), $validation_rules, $validation_messages, $attributes);
        $validator->after(function ($validator) {});

        return $validator;
    }

    public function processProfileUpdate(Request $request){

        $current_user = Auth()->user();

        $validator = $this->validateUserDetails($request);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($current_user != null){
            $current_user->email = $request->email;
            $current_user->telephone = $request->telephone;
            if (!empty($request->password)){
                $current_user->password = Hash::make($request->password);
            }
            
            $current_user->save();
            $request->session()->flash('success','Your profile has been updated.');
        }

        return redirect()->route('profile');
    }


}