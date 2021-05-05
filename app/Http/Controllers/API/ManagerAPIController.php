<?php

namespace App\Http\Controllers\API;

use App\Events\ManagerCreated;
use App\Events\ManagerUpdated;
use App\Events\ManagerDeleted;

use App\Http\Requests\API\CreateManagerAPIRequest;
use App\Http\Requests\API\UpdateManagerAPIRequest;
use App\Models\Manager;
use App\Repositories\ManagerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ManagerResource;
use Response;

/**
 * Class ManagerController
 * @package App\Http\Controllers\API
 */

class ManagerAPIController extends AppBaseController
{
    /** @var  ManagerRepository */
    private $managerRepository;

    public function __construct(ManagerRepository $managerRepo)
    {
        $this->managerRepository = $managerRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/managers",
     *      summary="Get a listing of the Managers.",
     *      tags={"Manager"},
     *      description="Get all Managers",
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
     *                  @SWG\Items(ref="#/definitions/Manager")
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
        $managers = $this->managerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ManagerResource::collection($managers), 'Managers retrieved successfully');
    }

    /**
     * @param CreateManagerAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/managers",
     *      summary="Store a newly created Manager in storage",
     *      tags={"Manager"},
     *      description="Store Manager",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Manager that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Manager")
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
     *                  ref="#/definitions/Manager"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateManagerAPIRequest $request)
    {
        $input = $request->all();

        $manager = $this->managerRepository->create($input);
        
        ManagerCreated::dispatch($manager);
        return $this->sendResponse(new ManagerResource($manager), 'Manager saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/managers/{id}",
     *      summary="Display the specified Manager",
     *      tags={"Manager"},
     *      description="Get Manager",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Manager",
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
     *                  ref="#/definitions/Manager"
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
        /** @var Manager $manager */
        $manager = $this->managerRepository->find($id);

        if (empty($manager)) {
            return $this->sendError('Manager not found');
        }

        return $this->sendResponse(new ManagerResource($manager), 'Manager retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateManagerAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/managers/{id}",
     *      summary="Update the specified Manager in storage",
     *      tags={"Manager"},
     *      description="Update Manager",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Manager",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Manager that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Manager")
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
     *                  ref="#/definitions/Manager"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateManagerAPIRequest $request)
    {
        $input = $request->all();

        /** @var Manager $manager */
        $manager = $this->managerRepository->find($id);

        if (empty($manager)) {
            return $this->sendError('Manager not found');
        }

        $manager = $this->managerRepository->update($input, $id);
        
        ManagerUpdated::dispatch($manager);
        return $this->sendResponse(new ManagerResource($manager), 'Manager updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/managers/{id}",
     *      summary="Remove the specified Manager from storage",
     *      tags={"Manager"},
     *      description="Delete Manager",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Manager",
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
        /** @var Manager $manager */
        $manager = $this->managerRepository->find($id);

        if (empty($manager)) {
            return $this->sendError('Manager not found');
        }

        $manager->delete();
        ManagerDeleted::dispatch($manager);
        return $this->sendSuccess('Manager deleted successfully');
    }
}
