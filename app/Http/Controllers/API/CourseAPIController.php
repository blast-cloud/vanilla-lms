<?php

namespace App\Http\Controllers\API;

use App\Events\CourseCreated;
use App\Events\CourseUpdated;
use App\Events\CourseDeleted;

use App\Http\Requests\API\CreateCourseAPIRequest;
use App\Http\Requests\API\UpdateCourseAPIRequest;
use App\Http\Requests\API\BulkCourseApiRequest;
use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CourseResource;
use Response;

/**
 * Class CourseController
 * @package App\Http\Controllers\API
 */

class CourseAPIController extends AppBaseController
{
    /** @var  CourseRepository */
    private $courseRepository;

    public function __construct(CourseRepository $courseRepo)
    {
        $this->courseRepository = $courseRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/courses",
     *      summary="Get a listing of the Courses.",
     *      tags={"Course"},
     *      description="Get all Courses",
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
     *                  @SWG\Items(ref="#/definitions/Course")
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
        $courses = $this->courseRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(CourseResource::collection($courses), 'Courses retrieved successfully');
    }

    /**
     * @param CreateCourseAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/courses",
     *      summary="Store a newly created Course in storage",
     *      tags={"Course"},
     *      description="Store Course",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Course that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Course")
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
     *                  ref="#/definitions/Course"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCourseAPIRequest $request)
    {
        $input = $request->all();

        $course = $this->courseRepository->create($input);
        
        CourseCreated::dispatch($course);
        return $this->sendResponse(new CourseResource($course), 'Course saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/courses/{id}",
     *      summary="Display the specified Course",
     *      tags={"Course"},
     *      description="Get Course",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Course",
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
     *                  ref="#/definitions/Course"
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
        /** @var Course $course */
        $course = $this->courseRepository->find($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        return $this->sendResponse(new CourseResource($course), 'Course retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCourseAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/courses/{id}",
     *      summary="Update the specified Course in storage",
     *      tags={"Course"},
     *      description="Update Course",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Course",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Course that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Course")
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
     *                  ref="#/definitions/Course"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCourseAPIRequest $request)
    {
        $input = $request->all();

        /** @var Course $course */
        $course = $this->courseRepository->find($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        $course = $this->courseRepository->update($input, $id);
        
        CourseUpdated::dispatch($course);
        return $this->sendResponse(new CourseResource($course), 'Course updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/courses/{id}",
     *      summary="Remove the specified Course from storage",
     *      tags={"Course"},
     *      description="Delete Course",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Course",
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
        /** @var Course $course */
        $course = $this->courseRepository->find($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        $course->delete();
        CourseDeleted::dispatch($course);
        return $this->sendSuccess('Course deleted successfully');
    }

    public function uploadBulkCourses(BulkCourseApiRequest $request)
    {
        $extension = $request->file('bulk_course_file')->getClientOriginalExtension();
        $attachedFileName = time() . '.' . $extension;
        $request->file('bulk_course_file')->move(public_path('uploads'), $attachedFileName);
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
                    $course_data = array_merge($request->input(), [
                    'code' => $data[0],
                    'name' => $data[1],
                    'description' => $data[2],
                    'credit_hours' => $data[3],
                  ]);     
                    $course = Course::create($course_data); 
                    CourseCreated::dispatch($course);
                  }
                }else{
                    $headers = explode(',', $line);
                    if (count($headers) != 4 || trim(strtolower($headers[1]), "\r\n") != 'name' || trim(strtolower($headers[2]), "\r\n") != 'description' || trim(strtolower($headers[3]), "\r\n") != 'credit_hours') {
                        $invalids['inc'] = 'The file format is incorrect: Must be - "code,name,credit_hours" ';
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

        $user = Course::where('code', $data[0])->first();
        if ($user) {
            $errors[] = 'The code: '.$data[0].' already belongs to a course';
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
}
