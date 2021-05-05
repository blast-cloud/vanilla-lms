<?php

namespace App\Http\Controllers\API;

use App\Events\LecturerCreated;
use App\Events\LecturerUpdated;
use App\Events\LecturerDeleted;

use App\Http\Requests\API\CreateLecturerAPIRequest;
use App\Http\Requests\API\UpdateLecturerAPIRequest;
use App\Models\Lecturer;
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
}
