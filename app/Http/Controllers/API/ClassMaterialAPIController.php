<?php

namespace App\Http\Controllers\API;

use App\Events\ClassMaterialCreated;
use App\Events\ClassMaterialUpdated;
use App\Events\ClassMaterialDeleted;

use App\Http\Requests\API\CreateClassMaterialAPIRequest;
use App\Http\Requests\API\UpdateClassMaterialAPIRequest;
use App\Models\ClassMaterial;
use App\Repositories\ClassMaterialRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ClassMaterialResource;
use Response;

/**
 * Class ClassMaterialController
 * @package App\Http\Controllers\API
 */

class ClassMaterialAPIController extends AppBaseController
{
    /** @var  ClassMaterialRepository */
    private $classMaterialRepository;

    public function __construct(ClassMaterialRepository $classMaterialRepo)
    {
        $this->classMaterialRepository = $classMaterialRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/classMaterials",
     *      summary="Get a listing of the ClassMaterials.",
     *      tags={"ClassMaterial"},
     *      description="Get all ClassMaterials",
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
     *                  @SWG\Items(ref="#/definitions/ClassMaterial")
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
        $classMaterials = $this->classMaterialRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ClassMaterialResource::collection($classMaterials), 'Class Materials retrieved successfully');
    }

    /**
     * @param CreateClassMaterialAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/classMaterials",
     *      summary="Store a newly created ClassMaterial in storage",
     *      tags={"ClassMaterial"},
     *      description="Store ClassMaterial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ClassMaterial that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ClassMaterial")
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
     *                  ref="#/definitions/ClassMaterial"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateClassMaterialAPIRequest $request)
    {
        $input = $request->all();

        $classMaterial = $this->classMaterialRepository->create($input);
        
        ClassMaterialCreated::dispatch($classMaterial);
        return $this->sendResponse(new ClassMaterialResource($classMaterial), 'Class Material saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/classMaterials/{id}",
     *      summary="Display the specified ClassMaterial",
     *      tags={"ClassMaterial"},
     *      description="Get ClassMaterial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ClassMaterial",
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
     *                  ref="#/definitions/ClassMaterial"
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
        /** @var ClassMaterial $classMaterial */
        $classMaterial = $this->classMaterialRepository->find($id);

        if (empty($classMaterial)) {
            return $this->sendError('Class Material not found');
        }

        return $this->sendResponse(new ClassMaterialResource($classMaterial), 'Class Material retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateClassMaterialAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/classMaterials/{id}",
     *      summary="Update the specified ClassMaterial in storage",
     *      tags={"ClassMaterial"},
     *      description="Update ClassMaterial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ClassMaterial",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ClassMaterial that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ClassMaterial")
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
     *                  ref="#/definitions/ClassMaterial"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateClassMaterialAPIRequest $request)
    {
        $input = $request->all();

        /** @var ClassMaterial $classMaterial */
        $classMaterial = $this->classMaterialRepository->find($id);

        if (empty($classMaterial)) {
            return $this->sendError('Class Material not found');
        }

        $classMaterial = $this->classMaterialRepository->update($input, $id);
        
        ClassMaterialUpdated::dispatch($classMaterial);
        return $this->sendResponse(new ClassMaterialResource($classMaterial), 'ClassMaterial updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/classMaterials/{id}",
     *      summary="Remove the specified ClassMaterial from storage",
     *      tags={"ClassMaterial"},
     *      description="Delete ClassMaterial",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ClassMaterial",
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
        /** @var ClassMaterial $classMaterial */
        $classMaterial = $this->classMaterialRepository->find($id);

        if (empty($classMaterial)) {
            return $this->sendError('Class Material not found');
        }

        $classMaterial->delete();
        ClassMaterialDeleted::dispatch($classMaterial);
        return $this->sendSuccess('Class Material deleted successfully');
    }
}
