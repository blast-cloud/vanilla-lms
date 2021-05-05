<?php

namespace App\Http\Controllers;

use App\Events\ForumCreated;
use App\Events\ForumUpdated;
use App\Events\ForumDeleted;

use App\DataTables\ForumDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateForumRequest;
use App\Http\Requests\UpdateForumRequest;
use App\Repositories\ForumRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ForumController extends AppBaseController
{
    /** @var  ForumRepository */
    private $forumRepository;

    public function __construct(ForumRepository $forumRepo)
    {
        $this->forumRepository = $forumRepo;
    }

    /**
     * Display a listing of the Forum.
     *
     * @param ForumDataTable $forumDataTable
     * @return Response
     */
    public function index(ForumDataTable $forumDataTable)
    {
        return $forumDataTable->render('forums.index');
    }

    /**
     * Show the form for creating a new Forum.
     *
     * @return Response
     */
    public function create()
    {
        return view('forums.create');
    }

    /**
     * Store a newly created Forum in storage.
     *
     * @param CreateForumRequest $request
     *
     * @return Response
     */
    public function store(CreateForumRequest $request)
    {
        $input = $request->all();

        $forum = $this->forumRepository->create($input);

        Flash::success('Forum saved successfully.');
        
        ForumCreated::dispatch($forum);
        return redirect(route('forums.index'));
    }

    /**
     * Display the specified Forum.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $forum = $this->forumRepository->find($id);

        if (empty($forum)) {
            Flash::error('Forum not found');

            return redirect(route('forums.index'));
        }

        return view('forums.show')->with('forum', $forum);
    }

    /**
     * Show the form for editing the specified Forum.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $forum = $this->forumRepository->find($id);

        if (empty($forum)) {
            Flash::error('Forum not found');

            return redirect(route('forums.index'));
        }

        return view('forums.edit')->with('forum', $forum);
    }

    /**
     * Update the specified Forum in storage.
     *
     * @param  int              $id
     * @param UpdateForumRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateForumRequest $request)
    {
        $forum = $this->forumRepository->find($id);

        if (empty($forum)) {
            Flash::error('Forum not found');

            return redirect(route('forums.index'));
        }

        $forum = $this->forumRepository->update($request->all(), $id);

        Flash::success('Forum updated successfully.');
        
        ForumUpdated::dispatch($forum);
        return redirect(route('forums.index'));
    }

    /**
     * Remove the specified Forum from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $forum = $this->forumRepository->find($id);

        if (empty($forum)) {
            Flash::error('Forum not found');

            return redirect(route('forums.index'));
        }

        $this->forumRepository->delete($id);

        Flash::success('Forum deleted successfully.');

        ForumDeleted::dispatch($forum);
        return redirect(route('forums.index'));
    }
}
