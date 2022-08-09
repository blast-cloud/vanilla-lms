<?php

namespace App\Http\Controllers\API;

use App\Events\EnrollmentCreated;
use App\Events\EnrollmentUpdated;
use App\Events\EnrollmentDeleted;

use App\Http\Requests\API\CreateEnrollmentAPIRequest;
use App\Http\Requests\API\UpdateEnrollmentAPIRequest;
use App\Http\Requests\API\CreateBulkCourseClassEnrollmentAPIRequest;
use App\Models\Enrollment;
use App\Models\Student;
use App\Repositories\EnrollmentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\EnrollmentResource;
use Response;

/**
 * Class EnrollmentController
 * @package App\Http\Controllers\API
 */

class EnrollmentAPIController extends AppBaseController
{
    /** @var  EnrollmentRepository */
    private $enrollmentRepository;

    public function __construct(EnrollmentRepository $enrollmentRepo)
    {
        $this->enrollmentRepository = $enrollmentRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/enrollments",
     *      summary="Get a listing of the Enrollments.",
     *      tags={"Enrollment"},
     *      description="Get all Enrollments",
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
     *                  @SWG\Items(ref="#/definitions/Enrollment")
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
        $enrollments = $this->enrollmentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(EnrollmentResource::collection($enrollments), 'Enrollments retrieved successfully');
    }

    /**
     * @param CreateEnrollmentAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/enrollments",
     *      summary="Store a newly created Enrollment in storage",
     *      tags={"Enrollment"},
     *      description="Store Enrollment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Enrollment that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Enrollment")
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
     *                  ref="#/definitions/Enrollment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateEnrollmentAPIRequest $request)
    {
        $input = $request->all();

        $enrollment = $this->enrollmentRepository->create($input);
        
        EnrollmentCreated::dispatch($enrollment);
        return $this->sendResponse(new EnrollmentResource($enrollment), 'Enrollment saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/enrollments/{id}",
     *      summary="Display the specified Enrollment",
     *      tags={"Enrollment"},
     *      description="Get Enrollment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Enrollment",
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
     *                  ref="#/definitions/Enrollment"
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
        /** @var Enrollment $enrollment */
       // $enrollment = $this->enrollmentRepository->find($id);
        $enrollment = Enrollment::with('student','courseClass')->find($id);

        if (empty($enrollment)) {
            return $this->sendError('Enrollment not found');
        }

        return $this->sendResponse($enrollment, 'Enrollment retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateEnrollmentAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/enrollments/{id}",
     *      summary="Update the specified Enrollment in storage",
     *      tags={"Enrollment"},
     *      description="Update Enrollment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Enrollment",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Enrollment that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Enrollment")
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
     *                  ref="#/definitions/Enrollment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateEnrollmentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Enrollment $enrollment */
        $enrollment = $this->enrollmentRepository->find($id);

        if (empty($enrollment)) {
            return $this->sendError('Enrollment not found');
        }

        $enrollment = $this->enrollmentRepository->update($input, $id);
        
        EnrollmentUpdated::dispatch($enrollment);
        return $this->sendResponse(new EnrollmentResource($enrollment), 'Enrollment updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/enrollments/{id}",
     *      summary="Remove the specified Enrollment from storage",
     *      tags={"Enrollment"},
     *      description="Delete Enrollment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Enrollment",
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
        /** @var Enrollment $enrollment */
        $enrollment = $this->enrollmentRepository->find($id);

        if (empty($enrollment)) {
            return $this->sendError('Enrollment not found');
        }

        $enrollment->delete();
        EnrollmentDeleted::dispatch($enrollment);
        return $this->sendSuccess('Enrollment deleted successfully');
    }

    public function approveEnrollment($id,Request $request){
        $enrollment = Enrollment::find($id);
        if(empty($enrollment)){
            return $this->sendError('Enrollment not found');
        }
        $enrollment = $enrollment->update(['is_approved' => $request->get('is_approved')]);

        return $this->sendResponse($enrollment, 'Enrollment updated successfully');
     }
     public function bulkEnrollment(CreateBulkCourseClassEnrollmentAPIRequest $request){

        $course_class_id = $request->course_class_id;
        $department_id = $request->department_id;
        $semester_id = $request->semester_id;

        $students = Student::where('department_id', $department_id )->where('level', $request->level)->get();
        $errors = [];
        $sucesses = [];
         foreach ($students as $student) {
            # validate enrollment status exists
          
           $status = $this->validateStudentEnrollmentExists( $course_class_id,$semester_id,$department_id,$student->id);
           if($status == true){

            $errors [] = $student->getFullName(). " with matric no ".$student->matriculation_number. " has already been enrolled for the selec course class";

           }else{
             $enrollment = new Enrollment();
             $enrollment->course_class_id = $course_class_id;
             $enrollment->department_id = $department_id;
             $enrollment->semester_id = $semester_id;
             $enrollment->student_id = $student->id;
             $enrollment->save();
             $sucesses [] = $student->getFullName(). " with matric no ".$student->matriculation_number. " was enrolled sucessfully";
           }
         }   
         if(count($errors) > 0){
            if(count($errors) == $students->count()){
                return response()->json(['enrollment_errors' => ['All students already enrolled in this course class']]); 
            }

           return response()->json(['enrollment_errors' => $errors, 'enrollment_successes' => $sucesses]);
         }
        return $this->sendResponse([], 'Enrollment saved successfully');
     }

     public function validateStudentEnrollmentExists($course_class_id,$semester_id,$department_id,$student_id){
       
        $enrollment = Enrollment::where('course_class_id',$course_class_id)
        ->where('semester_id',$semester_id)
        ->where('department_id',$department_id)
        ->where('student_id',$student_id)->first();
        if($enrollment != null){
            return true;
        }
        return false;
     }
}
