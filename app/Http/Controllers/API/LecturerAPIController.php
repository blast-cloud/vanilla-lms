<?php

namespace App\Http\Controllers\API;

use App\Events\LecturerCreated;
use App\Events\LecturerUpdated;
use App\Events\LecturerDeleted;

use Illuminate\Support\Facades\Http;
use App\Http\Requests\API\CreateLecturerAPIRequest;
use App\Http\Requests\API\UpdateLecturerAPIRequest;
use App\Http\Requests\API\BulkLecturerApiRequest;
use App\Http\Requests\UpdateUserPasswordResetRequest;
use App\Models\Lecturer;
use App\Models\User;
use App\Repositories\LecturerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\LecturerResource;
use Response;


/**
 * Class LecturerController
 * @package App\Http\Controllers\API
 */

class LecturerAPIController extends AppBaseController
{
    /** @var  LecturerRepository */
    private $lecturerRepository;

    public function __construct(LecturerRepository $lecturerRepo)
    {
        $this->lecturerRepository = $lecturerRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/lecturers",
     *      summary="Get a listing of the Lecturers.",
     *      tags={"Lecturer"},
     *      description="Get all Lecturers",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Lecturer")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $lecturers = $this->lecturerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(LecturerResource::collection($lecturers), 'Lecturers retrieved successfully');
    }

    /**
     * @param CreateLecturerAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/lecturers",
     *      summary="Store a newly created Lecturer in storage",
     *      tags={"Lecturer"},
     *      description="Store Lecturer",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Lecturer that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Lecturer")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Lecturer"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLecturerAPIRequest $request)
    {
        $input = $request->all();

        $lecturer = $this->lecturerRepository->create($input);
        
        LecturerCreated::dispatch($lecturer);
        return $this->sendResponse(new LecturerResource($lecturer), 'Lecturer saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/lecturers/{id}",
     *      summary="Display the specified Lecturer",
     *      tags={"Lecturer"},
     *      description="Get Lecturer",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Lecturer",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Lecturer"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Lecturer $lecturer */
        $lecturer = $this->lecturerRepository->find($id);

        if (empty($lecturer)) {
            return $this->sendError('Lecturer not found');
        }

        return $this->sendResponse(new LecturerResource($lecturer), 'Lecturer retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLecturerAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/lecturers/{id}",
     *      summary="Update the specified Lecturer in storage",
     *      tags={"Lecturer"},
     *      description="Update Lecturer",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Lecturer",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Lecturer that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Lecturer")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Lecturer"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLecturerAPIRequest $request)
    {
        $input = $request->all();

        /** @var Lecturer $lecturer */
        $lecturer = $this->lecturerRepository->find($id);

        if (empty($lecturer)) {
            return $this->sendError('Lecturer not found');
        }

        $lecturer = $this->lecturerRepository->update($input, $id);
        
        LecturerUpdated::dispatch($lecturer);
        return $this->sendResponse(new LecturerResource($lecturer), 'Lecturer updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/lecturers/{id}",
     *      summary="Remove the specified Lecturer from storage",
     *      tags={"Lecturer"},
     *      description="Delete Lecturer",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Lecturer",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Lecturer $lecturer */
        $lecturer = $this->lecturerRepository->find($id);

        if (empty($lecturer)) {
            return $this->sendError('Lecturer not found');
        }

        $lecturer->delete();
        LecturerDeleted::dispatch($lecturer);
        return $this->sendSuccess('Lecturer deleted successfully');
    }

    public function uploadBulkStaff(BulkLecturerApiRequest $request)
    {
        $extension = $request->file('bulk_staff_file')->getClientOriginalExtension();
        $attachedFileName = time() . '.' . $extension;
        $request->file('bulk_staff_file')->move(public_path('uploads'), $attachedFileName);
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
                    $invalids = $this->validateValues($data);
                  if (count($invalids) > 0) {
                    array_push($errors, $invalids);
                    continue;
                  }else{
                    $bims_data = [
                        'client_id' => env('BIMS_CLIENT_ID'),
                        'first_name' => $data[1],
                        'last_name' => $data[2],
                        'email' => $data[0],
                        'phone' => $data[4],
                        'gender' => "M"
                    ];
                    if ($data[3] == 'Male') {
                        $bims_data['gender'] = "M";
                    } else {
                        $bims_data['gender'] = "F";
                    }       
                    $register_for_bims = Http::acceptJson()->post(env('BIMS_CREATE_USER_URL'), $bims_data);
                    
                    $staff_data = array_merge($request->input(), [
                        'email' => $data[0],
                        'first_name' => $data[1],
                        'last_name' => $data[2],
                        'telephone' => $data[4],
                        'sex' => $data[3]
                      ]);     
                    $lecturer = Lecturer::create($staff_data); 
                    LecturerCreated::dispatch($lecturer);
                  }
                }else{
                    $headers = explode(',', $line);
                    if (strtolower($headers[0]) != 'email') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "email,first_name,last_name,telephone"';
                        array_push($errors, $invalids);
                        break;
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

    public function validateValues($data)
    {
        $errors = [];
        // validte email
        if (!filter_var($data[0], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'The email: '.$data[0].' is invalid';
        }

        // validate email uniqueness
        $student = Lecturer::where('email', $data[0])->first();
        if ($student) {
            $errors[] = 'The email: '.$data[0].' already exist';
        }

        $user = User::where('email', $data[0])->first();
        if ($user) {
            $errors[] = 'The email: '.$data[0].' already belongs to a user';
        }

        // validate phone number
        $student = Lecturer::where('telephone', $data[4])->first();
        if ($student) {
            $errors[] = 'The telephone number: '.$data[4].' already exist';
        }

        $user = User::where('telephone', $data[4])->first();
        if ($user) {
            $errors[] = 'The telephone number: '.$data[4].' already belongs to a user';
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

    public function resetLecturerPassword(UpdateUserPasswordResetRequest $request)
    {
        $lecturer = Lecturer::find($request->id);
        if (!$lecturer) {
            return response()->json(['errors'=>['not found'=>'Lecturer not found']]);
        }
        $user = $lecturer->user;
        $user->password = \Hash::make($request->password);
        $user->save();

        return true;
    }
}
