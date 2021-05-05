<?php

namespace App\Http\Controllers\API;

use App\Events\SemesterCreated;
use App\Events\SemesterUpdated;
use App\Events\SemesterDeleted;

use App\Http\Requests\API\CreateSemesterAPIRequest;
use App\Http\Requests\API\UpdateSemesterAPIRequest;
use App\Models\Semester;
use App\Repositories\SemesterRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\SemesterResource;
use Response;

/**
 * Class SemesterController
 * @package App\Http\Controllers\API
 */

class SemesterAPIController extends AppBaseController
{
    /** @var  SemesterRepository */
    private $semesterRepository;

    public function __construct(SemesterRepository $semesterRepo)
    {
        $this->semesterRepository = $semesterRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/semesters",
     *      summary="Get a listing of the Semesters.",
     *      tags={"Semester"},
     *      description="Get all Semesters",
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
     *                  @SWG\Items(ref="#/definitions/Semester")
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
        $semesters = $this->semesterRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SemesterResource::collection($semesters), 'Semesters retrieved successfully');
    }

    /**
     * @param CreateSemesterAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/semesters",
     *      summary="Store a newly created Semester in storage",
     *      tags={"Semester"},
     *      description="Store Semester",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Semester that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Semester")
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
     *                  ref="#/definitions/Semester"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSemesterAPIRequest $request)
    {
        $input = $request->all();

        $semester = $this->semesterRepository->create($input);
        
        SemesterCreated::dispatch($semester);
        return $this->sendResponse(new SemesterResource($semester), 'Semester saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/semesters/{id}",
     *      summary="Display the specified Semester",
     *      tags={"Semester"},
     *      description="Get Semester",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Semester",
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
     *                  ref="#/definitions/Semester"
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
        /** @var Semester $semester */
        $semester = $this->semesterRepository->find($id);

        if (empty($semester)) {
            return $this->sendError('Semester not found');
        }

        return $this->sendResponse(new SemesterResource($semester), 'Semester retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSemesterAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/semesters/{id}",
     *      summary="Update the specified Semester in storage",
     *      tags={"Semester"},
     *      description="Update Semester",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Semester",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Semester that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Semester")
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
     *                  ref="#/definitions/Semester"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSemesterAPIRequest $request)
    {
        $input = $request->all();

        /** @var Semester $semester */
        $semester = $this->semesterRepository->find($id);

        if (empty($semester)) {
            return $this->sendError('Semester not found');
        }

        $semester = $this->semesterRepository->update($input, $id);
        
        SemesterUpdated::dispatch($semester);
        return $this->sendResponse(new SemesterResource($semester), 'Semester updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/semesters/{id}",
     *      summary="Remove the specified Semester from storage",
     *      tags={"Semester"},
     *      description="Delete Semester",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Semester",
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
        /** @var Semester $semester */
        $semester = $this->semesterRepository->find($id);

        if (empty($semester)) {
            return $this->sendError('Semester not found');
        }

        $semester->delete();
        SemesterDeleted::dispatch($semester);
        return $this->sendSuccess('Semester deleted successfully');
    }
}
