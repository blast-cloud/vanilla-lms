<?php

namespace App\Http\Controllers\ACL;

use App\DataTables\UserAccountsDataTable;
use Carbon;
use Session;
use Validator;

use App\Models\User;
use App\Models\Department;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserPasswordResetRequest;

use App\Repositories\StudentRepository;
use App\Repositories\ManagerRepository;
use App\Repositories\LecturerRepository;

use App\Events\StudentCreated;
use App\Events\ManagerCreated;
use App\Events\LecturerCreated;

class ACLController extends AppBaseController
{

    /** @var  LecturerRepository */
    private $lecturerRepository;

    /** @var  StudentRepository */
    private $studentRepository;

    /** @var  ManagerRepository */
    private $managerRepository;


    public function __construct(
        StudentRepository $studentRepo,
        ManagerRepository $managerRepo,
        LecturerRepository $lecturerRepo)
    {
        $this->lecturerRepository = $lecturerRepo;
        $this->managerRepository = $managerRepo;
        $this->studentRepository = $studentRepo;
    }


    public function getUser(Request $request, $id){
        
        $current_user = User::find($id);

        $matric_num = "";
        $first_name = "System";
        $last_name = "Administrator";

        if ($current_user->manager_id != null){
            $first_name = $current_user->manager->first_name;
            $last_name = $current_user->manager->last_name;

        }else if ($current_user->student_id != null){
            $matric_num = $current_user->student->matriculation_number;
            $first_name = $current_user->student->first_name;
            $last_name = $current_user->student->last_name;
    
        }else if ($current_user->lecturer_id != null){
            $first_name = $current_user->lecturer->first_name;
            $last_name = $current_user->lecturer->last_name;
        }

        return $current_user;

    }

    public function deleteUserAccount(Request $request, $id){
        $current_user = User::find($id);
        $current_user->delete();
        return $current_user;
    }

    public function resetPwdUserAccount(UpdateUserPasswordResetRequest $request, $id){
        $current_user = User::find($id);
        $current_user->password = Hash::make($request->password);
        $current_user->save();
        return $current_user;
    }

    public function enableUserAccount(Request $request, $id){
        $current_user = User::find($id);
        $current_user->is_disabled = false;
        $current_user->save();
        return $current_user;
    }

    public function disableUserAccount(Request $request, $id){
        $current_user = User::find($id);
        $current_user->is_disabled = true;
        $current_user->save();
        return $current_user;
    }

    public function updateUserAccount(UpdateUserRequest $request, $id){

        if($id != '0'){
            $current_user = User::find($id);

            if ( ($current_user) && $current_user->manager_id != null){
                $current_user->manager->first_name = $request->first_name;
                $current_user->manager->last_name = $request->last_name;
                $current_user->department_id = $request->department_id;
                $current_user->manager->save();
    
            }else if ( ($current_user) && $current_user->student_id != null){
                $current_user->student->matriculation_number = $request->matriculation_number;
                $current_user->student->first_name = $request->first_name;
                $current_user->student->last_name = $request->last_name;
                $current_user->student->department_id = $request->department_id;
                $current_user->department_id = $request->department_id;
                $current_user->student->save();
        
            }else if ( ($current_user) && $current_user->lecturer_id != null){
                $current_user->lecturer->first_name = $request->first_name;
                $current_user->lecturer->last_name = $request->last_name;
                $current_user->lecturer->department_id = $request->department_id;
                $current_user->department_id = $request->department_id;
                $current_user->lecturer->save();
            }
    
            if (!empty($request->email) && $request->email!=null){
                $current_user->email = $request->email;
            }
    
            if (!empty($request->telephone) && $request->telephone!=null){
                $current_user->telephone = $request->telephone;
            }

            $current_user->save();
            return $current_user;

        }else{
            //$current_user = new User();
            if ($request->account_type == "student"){
                $input = $request->all();
                $student = $this->studentRepository->create($input);
                StudentCreated::dispatch($student);
                return $student->user;

            }else if ($request->account_type == "manager"){
                $input = $request->all();
                $manager = $this->managerRepository->create($input);
                ManagerCreated::dispatch($manager);
                return $manager->user;

            }else if ($request->account_type == "lecturer"){
                $input = $request->all();
                $lecturer = $this->lecturerRepository->create($input);
                LecturerCreated::dispatch($lecturer);
                return $lecturer->user;
            }
        }
        return null;
    }

    public function displayUserAccounts(Request $request){

        $current_user = Auth()->user();

        //Get User Accounts table
        $userAccountsDataTable = new UserAccountsDataTable();

        if ($request->expectsJson()) {
            return $userAccountsDataTable->ajax();
        }

        $departmentItems = Department::pluck('name','id')->toArray();

        return view('acl.user-accounts')
                    ->with("current_user", $current_user)
                    ->with("departmentItems", $departmentItems)
                    ->with('dataTable', $userAccountsDataTable->html());
    }

}
