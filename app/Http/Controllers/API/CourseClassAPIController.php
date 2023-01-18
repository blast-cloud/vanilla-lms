<?php

namespace App\Http\Controllers\API;

use App\Events\CourseClassCreated;
use App\Events\CourseClassUpdated;
use App\Events\CourseClassDeleted;

use App\Http\Requests\API\CreateCourseClassAPIRequest;
use App\Http\Requests\API\UpdateCourseClassAPIRequest;
use App\Models\CourseClass;
use App\Repositories\CourseClassRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CourseClassResource;
use Response;

/**
 * Class CourseClassController
 * @package App\Http\Controllers\API
 */

class CourseClassAPIController extends AppBaseController
{
    /** @var  CourseClassRepository */
    private $courseClassRepository;

    public function __construct(CourseClassRepository $courseClassRepo)
    {
        $this->courseClassRepository = $courseClassRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/courseClasses",
     *      summary="Get a listing of the CourseClasses.",
     *      tags={"CourseClass"},
     *      description="Get all CourseClasses",
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
     *                  @SWG\Items(ref="#/definitions/CourseClass")
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
        $courseClasses = $this->courseClassRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(CourseClassResource::collection($courseClasses), 'Course Classes retrieved successfully');
    }

    /**
     * @param CreateCourseClassAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/courseClasses",
     *      summary="Store a newly created CourseClass in storage",
     *      tags={"CourseClass"},
     *      description="Store CourseClass",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CourseClass that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CourseClass")
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
     *                  ref="#/definitions/CourseClass"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCourseClassAPIRequest $request)
    {
        $input = $request->all();

        $courseClass = $this->courseClassRepository->create($input);
        
        CourseClassCreated::dispatch($courseClass);
        return $this->sendResponse(new CourseClassResource($courseClass), 'Course Class saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/courseClasses/{id}",
     *      summary="Display the specified CourseClass",
     *      tags={"CourseClass"},
     *      description="Get CourseClass",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CourseClass",
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
     *                  ref="#/definitions/CourseClass"
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
        /** @var CourseClass $courseClass */
        $courseClass = $this->courseClassRepository->find($id);

        if (empty($courseClass)) {
            return $this->sendError('Course Class not found');
        }

        return $this->sendResponse(new CourseClassResource($courseClass), 'Course Class retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCourseClassAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/courseClasses/{id}",
     *      summary="Update the specified CourseClass in storage",
     *      tags={"CourseClass"},
     *      description="Update CourseClass",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CourseClass",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CourseClass that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CourseClass")
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
     *                  ref="#/definitions/CourseClass"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCourseClassAPIRequest $request)
    {
        $input = $request->all();

        /** @var CourseClass $courseClass */
        $courseClass = $this->courseClassRepository->find($id);

        if (empty($courseClass)) {
            return $this->sendError('Course Class not found');
        }

        $courseClass = $this->courseClassRepository->update($input, $id);
        
        CourseClassUpdated::dispatch($courseClass);
        return $this->sendResponse(new CourseClassResource($courseClass), 'CourseClass updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/courseClasses/{id}",
     *      summary="Remove the specified CourseClass from storage",
     *      tags={"CourseClass"},
     *      description="Delete CourseClass",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CourseClass",
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
        /** @var CourseClass $courseClass */
        $courseClass = $this->courseClassRepository->find($id);

        if (empty($courseClass)) {
            return $this->sendError('Course Class not found');
        }

        $courseClass->delete();
        CourseClassDeleted::dispatch($courseClass);
        return $this->sendSuccess('Course Class deleted successfully');
    }
    public function departmentSemesterCourse(Request $request){

        $courseClasses = CourseClass::with('lecturer')->where('semester_id',$request->semester_id)
                                    ->where('department_id',$request->department_id)
                                    ->where('level',$request->level)
                                    ->orderBy('name')->get();

        return $this->sendResponse($courseClasses->toArray(), "courseClases retrieved Successfully");
    }
}
