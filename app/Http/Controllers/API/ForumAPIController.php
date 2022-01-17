<?php

namespace App\Http\Controllers\API;

use App\Events\ForumCreated;
use App\Events\ForumUpdated;
use App\Events\ForumDeleted;

use App\Http\Requests\API\CreateForumAPIRequest;
use App\Http\Requests\API\UpdateForumAPIRequest;
use App\Models\Forum;
use App\Repositories\ForumRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ForumResource;
use Response;

/**
 * Class ForumController
 * @package App\Http\Controllers\API
 */

class ForumAPIController extends AppBaseController
{
    /** @var  ForumRepository */
    private $forumRepository;

    public function __construct(ForumRepository $forumRepo)
    {
        $this->forumRepository = $forumRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/forums",
     *      summary="Get a listing of the Forums.",
     *      tags={"Forum"},
     *      description="Get all Forums",
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
     *                  @SWG\Items(ref="#/definitions/Forum")
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
        $forums = $this->forumRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ForumResource::collection($forums), 'Forums retrieved successfully');
    }

    /**
     * @param CreateForumAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/forums",
     *      summary="Store a newly created Forum in storage",
     *      tags={"Forum"},
     *      description="Store Forum",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Forum that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Forum")
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
     *                  ref="#/definitions/Forum"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateForumAPIRequest $request)
    {
        $input = $request->all();

        $forum = $this->forumRepository->create($input);
        
        ForumCreated::dispatch($forum);
        return $this->sendResponse(new ForumResource($forum), 'Forum saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/forums/{id}",
     *      summary="Display the specified Forum",
     *      tags={"Forum"},
     *      description="Get Forum",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Forum",
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
     *                  ref="#/definitions/Forum"
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
        /** @var Forum $forum */
        $forum = $this->forumRepository->find($id);

        if (empty($forum)) {
            return $this->sendError('Forum not found');
        }

        return $this->sendResponse(new ForumResource($forum), 'Forum retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateForumAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/forums/{id}",
     *      summary="Update the specified Forum in storage",
     *      tags={"Forum"},
     *      description="Update Forum",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Forum",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Forum that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Forum")
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
     *                  ref="#/definitions/Forum"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateForumAPIRequest $request)
    {
        $input = $request->all();

        /** @var Forum $forum */
        $forum = $this->forumRepository->find($id);

        if (empty($forum)) {
            return $this->sendError('Forum not found');
        }

        $forum = $this->forumRepository->update($input, $id);
        
        ForumUpdated::dispatch($forum);
        return $this->sendResponse(new ForumResource($forum), 'Forum updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/forums/{id}",
     *      summary="Remove the specified Forum from storage",
     *      tags={"Forum"},
     *      description="Delete Forum",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Forum",
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
        /** @var Forum $forum */
        $forum = $this->forumRepository->find($id);

        if (empty($forum)) {
            return $this->sendError('Forum not found');
        }

        $forum->delete();
        ForumDeleted::dispatch($forum);
        return $this->sendSuccess('Forum deleted successfully');
    }
    
    public function getForumComments($id){

        $comments = Forum::with('posting_user')->where('parent_forum_id',$id)->get();

        if (empty($comments)) {
            return $this->sendError('Forum not found');
        }

        return $this->sendResponse($comments,'Forum deleted successfully');

    }
}
