<?php

namespace App\Http\Controllers\ACL;

use App\DataTables\UserAccountsDataTable;
use Carbon;
use Session;
use Validator;

use App\Models\User;
use App\Models\Student;
use App\Models\Manager;
use App\Models\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;

class ACLController extends Controller
{

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

    public function resetPwdUserAccount(Request $request, $id){
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
        
        $user_type = $request->user_type;
        $lms_user_type = null;
        if($id != '0'){
            $current_user = User::find($id);
        }else{
            $current_user = new User;
            if($user_type == 'student'){
                $lms_user_type = new Student;
            }elseif($user_type == 'lecturer'){
                $lms_user_type = new Lecturer;
            }if($user_type == 'manager'){
                $lms_user_type = new Manager;
            }
        }



        if ( ($current_user) && $current_user->manager_id != null){
            $current_user->manager = $request->first_name;
            $current_user->manager = $request->last_name;
            $user_type->save();

        }else if ( ($current_user) && $current_user->student_id != null){
            $current_user->student->matriculation_number = $request->matriculation_number;
            $current_user->student->first_name = $request->first_name;
            $current_user->student->last_name = $request->last_name;
            $current_user->student->save();
    
        }else if ( ($current_user) && $current_user->lecturer_id != null){
            $current_user->lecturer->first_name = $request->first_name;
            $current_user->lecturer->last_name = $request->last_name;
            $current_user->lecturer->save();
        }else {
            $lms_user_type->first_name = $request->first_name;
            $lms_user_type->last_name = $request->last_name;
            $lms_user_type->email = $request->email;
            $lms_user_type->telephone = $request->telephone;
            if($user_type == 'student'){
                $lms_user_type->matriculation_number = $request->matriculation_number;
            }
            $lms_user_type->save();

        }
        
        if($id == 0){
             
            $current_user->password = bcrypt('password');
            if($request->user_type == 'student'){
                $current_user->student_id = $lms_user_type->id;
            }elseif($request->user_type == 'manager'){
                $current_user->manager_id = $lms_user_type->id;
            }elseif($request->user_type == 'lecturer'){
                $current_user->lecturer_id = $lms_user_type->id;
            }
                
        }

            $current_user->email = $request->email;
            $current_user->telephone = $request->telephone;
            $current_user->name = $request->first_name.' '.$request->last_name;
            $current_user->save();
        
        return $current_user;
    }

    public function displayUserAccounts(Request $request){

        $current_user = Auth()->user();

        //Get User Accounts table
        $userAccountsDataTable = new UserAccountsDataTable();

        if ($request->expectsJson()) {
            return $userAccountsDataTable->ajax();
        }

        return view('acl.user-accounts')
                    ->with("current_user", $current_user)
                    ->with('dataTable', $userAccountsDataTable->html());
    }

}
