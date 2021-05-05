<?php

namespace App\Http\Controllers\API;

use App\Events\SubmissionCreated;
use App\Events\SubmissionUpdated;
use App\Events\SubmissionDeleted;

use App\Http\Requests\API\CreateSubmissionAPIRequest;
use App\Http\Requests\API\UpdateSubmissionAPIRequest;
use App\Models\Submission;
use App\Repositories\SubmissionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\SubmissionResource;
use Response;

/**
 * Class SubmissionController
 * @package App\Http\Controllers\API
 */

class SubmissionAPIController extends AppBaseController
{
    /** @var  SubmissionRepository */
    private $submissionRepository;

    public function __construct(SubmissionRepository $submissionRepo)
    {
        $this->submissionRepository = $submissionRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/submissions",
     *      summary="Get a listing of the Submissions.",
     *      tags={"Submission"},
     *      description="Get all Submissions",
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
     *                  @SWG\Items(ref="#/definitions/Submission")
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
        $submissions = $this->submissionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SubmissionResource::collection($submissions), 'Submissions retrieved successfully');
    }

    /**
     * @param CreateSubmissionAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/submissions",
     *      summary="Store a newly created Submission in storage",
     *      tags={"Submission"},
     *      description="Store Submission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Submission that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Submission")
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
     *                  ref="#/definitions/Submission"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSubmissionAPIRequest $request)
    {
        $input = $request->all();

        $submission = $this->submissionRepository->create($input);
        
        SubmissionCreated::dispatch($submission);
        return $this->sendResponse(new SubmissionResource($submission), 'Submission saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/submissions/{id}",
     *      summary="Display the specified Submission",
     *      tags={"Submission"},
     *      description="Get Submission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Submission",
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
     *                  ref="#/definitions/Submission"
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
        /** @var Submission $submission */
        $submission = $this->submissionRepository->find($id);

        if (empty($submission)) {
            return $this->sendError('Submission not found');
        }

        return $this->sendResponse(new SubmissionResource($submission), 'Submission retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSubmissionAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/submissions/{id}",
     *      summary="Update the specified Submission in storage",
     *      tags={"Submission"},
     *      description="Update Submission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Submission",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Submission that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Submission")
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
     *                  ref="#/definitions/Submission"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSubmissionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Submission $submission */
        $submission = $this->submissionRepository->find($id);

        if (empty($submission)) {
            return $this->sendError('Submission not found');
        }

        $submission = $this->submissionRepository->update($input, $id);
        
        SubmissionUpdated::dispatch($submission);
        return $this->sendResponse(new SubmissionResource($submission), 'Submission updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/submissions/{id}",
     *      summary="Remove the specified Submission from storage",
     *      tags={"Submission"},
     *      description="Delete Submission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Submission",
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
        /** @var Submission $submission */
        $submission = $this->submissionRepository->find($id);

        if (empty($submission)) {
            return $this->sendError('Submission not found');
        }

        $submission->delete();
        SubmissionDeleted::dispatch($submission);
        return $this->sendSuccess('Submission deleted successfully');
    }
}
