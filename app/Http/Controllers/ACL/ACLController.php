<?php

namespace App\Http\Controllers\ACL;

use App\DataTables\UserAccountsDataTable;
use Carbon;
use Session;
use Validator;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

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

    public function updateUserAccount(Request $request, $id){
        $current_user = User::find($id);

        if ($current_user->manager_id != null){
            $current_user->manager->first_name = $request->first_name;
            $current_user->manager->last_name = $request->last_name;
            $current_user->manager->save();

        }else if ($current_user->student_id != null){
            $current_user->student->matriculation_number = $request->matric_num;
            $current_user->student->first_name = $request->first_name;
            $current_user->student->last_name = $request->last_name;
            $current_user->student->save();
    
        }else if ($current_user->lecturer_id != null){
            $current_user->lecturer->first_name = $request->first_name;
            $current_user->lecturer->last_name = $request->last_name;
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
