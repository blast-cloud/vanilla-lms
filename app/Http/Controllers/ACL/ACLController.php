<?php

namespace App\Http\Controllers\ACL;

use App\DataTables\UserAccountsDataTable;
use Carbon;
use Session;
use Validator;

use App\Models\User;
use App\Models\Department;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Manager;

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
use App\Http\Requests\API\BulkUsersApiRequest;
use Illuminate\Support\Facades\Http;

use App\Repositories\StudentRepository;
use App\Repositories\ManagerRepository;
use App\Repositories\LecturerRepository;
use App\Repositories\LevelRepository;

use App\Events\StudentCreated;
use App\Events\ManagerCreated;
use App\Events\LecturerCreated;

use Illuminate\Support\Facades\Notification;
use App\Notifications\PasswordResetNotification;

class ACLController extends AppBaseController
{

    /** @var  LecturerRepository */
    private $lecturerRepository;

    /** @var  StudentRepository */
    private $studentRepository;

    /** @var  ManagerRepository */
    private $managerRepository;

    /** @var  LevelRepository */
    private $levelRepository;


    public function __construct(
        StudentRepository $studentRepo,
        ManagerRepository $managerRepo,
        LecturerRepository $lecturerRepo,
        LevelRepository $levelRepo)
    {
        $this->lecturerRepository = $lecturerRepo;
        $this->managerRepository = $managerRepo;
        $this->studentRepository = $studentRepo;
        $this->levelRepository = $levelRepo;
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

        //Send notification email
        Notification::send($current_user, new PasswordResetNotification($current_user, $request));

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

        $bims_data = [
            'client_id' => env('BIMS_CLIENT_ID'),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->telephone,
            'gender' => "M"
        ];

        if ($request->sex == 'Male') {
            $bims_data['gender'] = "M";
        } else {
            $bims_data['gender'] = "F";
        }
      
        //$register_for_bims = Http::acceptJson()->post(env('BIMS_CREATE_USER_URL'),  $bims_data);

        if($id != '0'){
            $current_user = User::find($id);

            if (($current_user) && $current_user->manager_id != null){
                if($request->account_type == "manager"){
                    $current_user->manager->first_name = $request->first_name;
                    $current_user->manager->last_name = $request->last_name;
                    $current_user->department_id = $request->department_id;
                    $current_user->manager->job_title = $request->job_title;
                    $current_user->manager->save();
                    $current_user->save();
                }elseif($request->account_type == "lecturer"){
                    $input = $request->all();
                    $lecturer = Lecturer::create($input);  

                    // $manager = Manager::find($current_user->manager_id);
                    // $manager->delete();

                    $current_user->lecturer_id = $lecturer->id;
                    $current_user->manager_id = null;
                    $current_user->save();     
                }
            }else if (($current_user) && $current_user->student_id != null){
                $current_user->student->matriculation_number = $request->matriculation_number;
                $current_user->student->first_name = $request->first_name;
                $current_user->student->last_name = $request->last_name;
                $current_user->student->department_id = $request->department_id;
                $current_user->department_id = $request->department_id;
                $current_user->sex = $request->sex;
                $current_user->student->sex = $request->sex;
                $current_user->student->level = $request->level;
                $current_user->student->has_graduated = $request->has_graduated;
                $current_user->student->save();
                $current_user->save();
        
            }else if (($current_user) && $current_user->lecturer_id != null){
                if($request->account_type == "lecturer"){
                    $current_user->lecturer->first_name = $request->first_name;
                    $current_user->lecturer->last_name = $request->last_name;
                    $current_user->lecturer->department_id = $request->department_id;
                    $current_user->department_id = $request->department_id;
                    $current_user->sex = $request->sex;
                    $current_user->lecturer->sex = $request->sex;
                    $current_user->lecturer->job_title = $request->job_title;
                    $current_user->lecturer->save();
                    $current_user->save();

                }elseif($request->account_type == "manager"){
                    $input = $request->all();
                    $manager = Manager::create($input); 
       
                    // $lecturer = Lecturer::find($current_user->lecturer_id);
                    // $lecturer->delete();
 
                    $current_user->manager_id = $manager->id;
                    $current_user->lecturer_id = null;
                    $current_user->save();    
                }
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

        $departmentItems = Department::pluck('name','id')->toArray();

        $departments = Department::select('name','id')->get();

        //Get User Accounts DataTable
        $userAccountsDataTable = new UserAccountsDataTable();
        $levels = $this->levelRepository->all();
             
        if ($request->expectsJson()) {
            
            return $userAccountsDataTable->ajax();
        }
        return $userAccountsDataTable->render('acl.user-accounts',

        compact('current_user', 'departmentItems','levels','departments'));                                 
    
    }

    public function uploadBulkUsers(BulkUsersApiRequest $request)
    {
        $extension = $request->file('bulk_user_file')->getClientOriginalExtension();
        $attachedFileName = time() . '.' . $extension;
        $request->file('bulk_user_file')->move(public_path('uploads'), $attachedFileName);
        $path_to_file = public_path('uploads').'/'.$attachedFileName;
       
        $errors = [];
        $loop = 1;
        $lines = file($path_to_file);
        if (count($lines) > 1) {
            foreach ($lines as $line) {
                // skip first line (heading line)
                if ($loop > 1) {
                    $data = explode(',', $line);
                    // dd($data);
                    $invalids = $this->validateValues($data, $request->type);
                  if (count($invalids) > 0) {
                    array_push($errors, $invalids);
                    continue;
                  }else{
                    $bims_data = [
                        'client_id' => env('BIMS_CLIENT_ID'),
                        'first_name' => trim($data[1]),
                        'last_name' => trim($data[2]),
                        'email' => trim($data[0]),
                        'phone' => trim($data[4]),
                        'gender' => "M"
                    ];
                    if (trim($data[3]) == 'Male') {
                        $bims_data['gender'] = "M";
                    } else {
                        $bims_data['gender'] = "F";
                    }       
                    //$register_for_bims = Http::acceptJson()->post(env('BIMS_CREATE_USER_URL'),  $bims_data);

                    list($valid, $msg) = $this->checknStoreUserType($request->type, $data);

                   if (!$valid) {
                       $errors[] = $msg;
                   }
                  }
                }else{
                    $type = $request->type;
                    $headers = explode(',', $line);
                    if($type == 'student'){
                        if (count($headers) != 7 || strtolower(trim($headers[0])) != 'email' || strtolower(trim($headers[1])) != 'first name' || strtolower(trim($headers[2])) != 'last name'  || strtolower(trim($headers[3])) != 'sex'  || trim(strtolower($headers['4'])) != 'telephone' || trim(strtolower($headers[5])) != 'matric no' || trim(strtolower($headers[6]), "\r\n") != 'level') {
                            $invalids['inc'] = 'The file format is incorrect. Must be - "Email,First Name,Last Name,Sex,Telephone,Matric no,Level"';
                            array_push($errors, $invalids);
                            break;
                        }
                    }elseif($type == 'lecturer'){
                        if (count($headers) != 5 || strtolower(trim($headers[0])) != 'email' || strtolower(trim($headers[1])) != 'first name' || strtolower(trim($headers[2])) != 'last name'  || strtolower(trim($headers[3])) != 'sex'  || trim(strtolower($headers['4']), "\r\n")  != 'telephone') {
                            $invalids['inc'] = 'The file format is incorrect. Must be - "Email,First Name,Last Name,Sex,Telephone"';
                            array_push($errors, $invalids);
                            break;
                        }
                    }elseif($type == 'manager'){
                        if (count($headers) != 5 || strtolower(trim($headers[0])) != 'email' || strtolower(trim($headers[1])) != 'first name' || strtolower(trim($headers[2])) != 'last name'  || strtolower(trim($headers[3])) != 'sex'  ||  trim(strtolower($headers['4']), "\r\n") != 'telephone') {
                            $invalids['inc'] = 'The file format is incorrect. Must be - "Email,First Name,Last Name,Sex,Telephone"';
                            array_push($errors, $invalids);
                            break;
                        }
                    }  
                }
                $loop++;
            }
        }else{
            $errors[] = 'The uploaded csv file is empty';
        }
        
        if (count($errors) > 0) {
            return response()->json(['errors' => $this->array_flatten($errors)]);
        }
        return true;
    }

    public function validateValues($data, $type)
    {
        $errors = [];
        // validate email
        if (!filter_var(trim($data[0]), FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'The email: '.trim($data[0]).' is invalid';
        }

        $user = User::where('email', trim($data[0]))->first();
        if ($user) {
            $errors[] = 'The email: '.trim($data[0]).' already belongs to a user';
        }

        $user = User::where('telephone', trim(strtolower($data[4]), "\r\n"))->first();
        if ($user) {
            $errors[] = 'The telephone number: '.trim(strtolower($data[4]), "\r\n").' already belongs to a user';
        }

        if ($type  == 'student') {
            // validate matric number
            $student = Student::where('matriculation_number', trim($data[5]))->first();
            if ($student) {
                $errors[] = 'The matriculation number: '.trim($data[5]).' already belongs to a student';
            }

            $student = Student::where('email', trim($data[0]))->first();
            if ($student) {
                $errors[] = 'The email: '.trim($data[0]).' already belongs to a student';
            }
        }elseif ($type == 'lecturer') {
            $lecturer = Lecturer::where('email', trim($data[0]))->first();
            if ($lecturer) {
                $errors[] = 'This email: '.trim($data[0]).' already belongs to a lecturer';
            }
        }elseif ($type == 'manager') {
            $lecturer = Manager::where('email', trim($data[0]))->first();
            if ($lecturer) {
                $errors[] = 'This email: '.trim($data[0]).' already belongs to a manager';
            }
        }
        return $errors;
    }

    public function array_flatten($array) {

       $return = array();
       foreach ($array as $key => $value) {
           if (is_array($value)){ $return = array_merge($return, $this->array_flatten($value));}
           else {$return[$key] = $value;}
       }
       return $return;
    }

    public function checknStoreUserType($type, $data)
    {
        // check for the type
        switch ($type) {
            case 'student':
                $ext_student_data = [
                    'email' => trim($data[0]),
                    'first_name' => trim($data[1]),
                    'last_name' => trim($data[2]),
                    'telephone' => trim(strtolower($data[4]), "\r\n"),
                    'sex' => trim($data[3]),
                    'matriculation_number' => trim($data[5]),
                    'level' => trim($data[6]),
                    'department_id' => auth()->user()->department_id ?? null
                ];
                if(strtolower(trim($data[3])) == 'm' || strtolower(trim($data[3])) == 'male'){
                    $ext_student_data['sex'] = "Male";
                }elseif(strtolower(trim($data[3])) == 'f' || strtolower(trim($data[3])) == 'female'){
                    $ext_student_data['sex'] = "Female";
                }
                $student_data = array_merge(request()->input(),$ext_student_data);     
                $student = $this->studentRepository->create($student_data);
                StudentCreated::dispatch($student);
            break;

            case 'lecturer':
                $ext_lecturer_data = [
                    'email' => trim($data[0]),
                    'first_name' => trim($data[1]),
                    'last_name' => trim($data[2]),
                    'telephone' => trim(strtolower($data[4]), "\r\n"),
                    'sex' => trim($data[3])
                ];
                if(strtolower(trim($data[3])) == 'm' || strtolower(trim($data[3])) == 'male'){
                    $ext_lecturer_data['sex'] = "Male";
                }elseif(strtolower(trim($data[3])) == 'f' || strtolower(trim($data[3])) == 'female'){
                    $ext_lecturer_data['sex'] = "Female";
                }
                $lecturer_data = array_merge(request()->input(),$ext_lecturer_data);     
                $lecturer = $this->lecturerRepository->create($lecturer_data);
                LecturerCreated::dispatch($lecturer);
            break;

            case 'manager':
                $ext_manager_data = [
                    'email' => trim($data[0]),
                    'first_name' => trim($data[1]),
                    'last_name' => trim($data[2]),
                    'telephone' =>  trim(strtolower($data[4]), "\r\n"),
                    'sex' => trim($data[3])
                ];
                if(strtolower(trim($data[3])) == 'm' || strtolower(trim($data[3])) == 'male'){
                    $ext_manager_data['sex'] = "Male";
                }elseif(strtolower(trim($data[3])) == 'f' || strtolower(trim($data[3])) == 'female'){
                    $ext_manager_data['sex'] = "Female";
                }
                $manager_data = array_merge(request()->input(),$ext_manager_data);     
                $manager = $this->managerRepository->create($manager_data); 
                ManagerCreated::dispatch($manager);
            break;
            
            default:
                return array(false, 'Invalid user type: '.$type);
                break;
        }

        return array(true,'');
    }

}
