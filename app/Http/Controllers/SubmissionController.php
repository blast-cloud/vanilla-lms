<?php

namespace App\Http\Controllers;

use App\Events\SubmissionCreated;
use App\Events\SubmissionUpdated;
use App\Events\SubmissionDeleted;

use App\DataTables\SubmissionDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use App\Repositories\SubmissionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SubmissionController extends AppBaseController
{
    /** @var  SubmissionRepository */
    private $submissionRepository;

    public function __construct(SubmissionRepository $submissionRepo)
    {
        $this->submissionRepository = $submissionRepo;
    }

    /**
     * Display a listing of the Submission.
     *
     * @param SubmissionDataTable $submissionDataTable
     * @return Response
     */
    public function index(SubmissionDataTable $submissionDataTable)
    {
        return $submissionDataTable->render('submissions.index');
    }

    /**
     * Show the form for creating a new Submission.
     *
     * @return Response
     */
    public function create()
    {
        return view('submissions.create');
    }

    /**
     * Store a newly created Submission in storage.
     *
     * @param CreateSubmissionRequest $request
     *
     * @return Response
     */
    public function store(CreateSubmissionRequest $request)
    {
        $input = $request->all();

        $submission = $this->submissionRepository->create($input);

        Flash::success('Submission saved successfully.');
        
        SubmissionCreated::dispatch($submission);
        return redirect(route('submissions.index'));
    }

    /**
     * Display the specified Submission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $submission = $this->submissionRepository->find($id);

        if (empty($submission)) {
            Flash::error('Submission not found');

            return redirect(route('submissions.index'));
        }

        return view('submissions.show')->with('submission', $submission);
    }

    /**
     * Show the form for editing the specified Submission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $submission = $this->submissionRepository->find($id);

        if (empty($submission)) {
            Flash::error('Submission not found');

            return redirect(route('submissions.index'));
        }

        return view('submissions.edit')->with('submission', $submission);
    }

    /**
     * Update the specified Submission in storage.
     *
     * @param  int              $id
     * @param UpdateSubmissionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubmissionRequest $request)
    {
        $submission = $this->submissionRepository->find($id);

        if (empty($submission)) {
            Flash::error('Submission not found');

            return redirect(route('submissions.index'));
        }

        $submission = $this->submissionRepository->update($request->all(), $id);

        Flash::success('Submission updated successfully.');
        
        SubmissionUpdated::dispatch($submission);
        return redirect(route('submissions.index'));
    }

    /**
     * Remove the specified Submission from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $submission = $this->submissionRepository->find($id);

        if (empty($submission)) {
            Flash::error('Submission not found');

            return redirect(route('submissions.index'));
        }

        $this->submissionRepository->delete($id);

        Flash::success('Submission deleted successfully.');

        SubmissionDeleted::dispatch($submission);
        return redirect(route('submissions.index'));
    }
}
