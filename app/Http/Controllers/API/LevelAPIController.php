<?php

namespace App\Http\Controllers\API;

use App\Events\LevelCreated;
use App\Events\LevelUpdated;
use App\Events\LevelDeleted;

use App\Http\Requests\API\CreateLevelAPIRequest;
use App\Http\Requests\API\UpdateLevelAPIRequest;
use App\Models\Level;
use App\Repositories\LevelRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\LevelResource;
use Response;

/**
 * Class LevelController
 * @package App\Http\Controllers\API
 */

class LevelAPIController extends AppBaseController
{
    /** @var  LevelRepository */
    private $levelRepository;

    public function __construct(LevelRepository $levelRepo)
    {
        $this->levelRepository = $levelRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/Levels",
     *      summary="Get a listing of the Levels.",
     *      tags={"Level"},
     *      description="Get all Levels",
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
     *                  @SWG\Items(ref="#/definitions/Level")
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
        $levels = $this->levelRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(LevelResource::collection($levels), 'Levels retrieved successfully');
    }

    /**
     * @param CreateLevelAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/Levels",
     *      summary="Store a newly created Level in storage",
     *      tags={"Level"},
     *      description="Store Level",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Level that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Level")
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
     *                  ref="#/definitions/Level"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLevelAPIRequest $request)
    {
        $input = $request->all();

        $level = $this->levelRepository->create($input);
        
        LevelCreated::dispatch($level);
        return $this->sendResponse(new LevelResource($level), 'Level saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/Levels/{id}",
     *      summary="Display the specified Level",
     *      tags={"Level"},
     *      description="Get Level",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Level",
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
     *                  ref="#/definitions/Level"
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
        /** @var Level $Level */
        $level = $this->levelRepository->find($id);

        if (empty($level)) {
            return $this->sendError('Level not found');
        }

        return $this->sendResponse(new LevelResource($level), 'Level retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLevelAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/Levels/{id}",
     *      summary="Update the specified Level in storage",
     *      tags={"Level"},
     *      description="Update Level",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Level",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Level that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Level")
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
     *                  ref="#/definitions/Level"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLevelAPIRequest $request)
    {
        $input = $request->all();

        /** @var Level $Level */
        $level = $this->levelRepository->find($id);

        if (empty($level)) {
            return $this->sendError('Level not found');
        }

        $level = $this->levelRepository->update($input, $id);
        
        LevelUpdated::dispatch($level);
        return $this->sendResponse(new LevelResource($level), 'Level updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/Levels/{id}",
     *      summary="Remove the specified Level from storage",
     *      tags={"Level"},
     *      description="Delete Level",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Level",
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
        /** @var Level $Level */
        $level = $this->levelRepository->find($id);

        if (empty($level)) {
            return $this->sendError('Level not found');
        }

        $level->delete();
        LevelDeleted::dispatch($level);
        return $this->sendSuccess('Level deleted successfully');
    }
}
