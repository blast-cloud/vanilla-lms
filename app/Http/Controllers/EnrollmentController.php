<?php

namespace App\Http\Controllers;

use App\Events\EnrollmentCreated;
use App\Events\EnrollmentUpdated;
use App\Events\EnrollmentDeleted;

use App\DataTables\EnrollmentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use App\Repositories\EnrollmentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class EnrollmentController extends AppBaseController
{
    /** @var  EnrollmentRepository */
    private $enrollmentRepository;

    public function __construct(EnrollmentRepository $enrollmentRepo)
    {
        $this->enrollmentRepository = $enrollmentRepo;
    }

    /**
     * Display a listing of the Enrollment.
     *
     * @param EnrollmentDataTable $enrollmentDataTable
     * @return Response
     */
    public function index(EnrollmentDataTable $enrollmentDataTable)
    {
        return $enrollmentDataTable->render('enrollments.index');
    }

    /**
     * Show the form for creating a new Enrollment.
     *
     * @return Response
     */
    public function create()
    {
        return view('enrollments.create');
    }

    /**
     * Store a newly created Enrollment in storage.
     *
     * @param CreateEnrollmentRequest $request
     *
     * @return Response
     */
    public function store(CreateEnrollmentRequest $request)
    {
        $input = $request->all();

        $enrollment = $this->enrollmentRepository->create($input);

        Flash::success('Enrollment saved successfully.');
        
        EnrollmentCreated::dispatch($enrollment);
        return redirect(route('enrollments.index'));
    }

    /**
     * Display the specified Enrollment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $enrollment = $this->enrollmentRepository->find($id);

        if (empty($enrollment)) {
            Flash::error('Enrollment not found');

            return redirect(route('enrollments.index'));
        }

        return view('enrollments.show')->with('enrollment', $enrollment);
    }

    /**
     * Show the form for editing the specified Enrollment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $enrollment = $this->enrollmentRepository->find($id);

        if (empty($enrollment)) {
            Flash::error('Enrollment not found');

            return redirect(route('enrollments.index'));
        }

        return view('enrollments.edit')->with('enrollment', $enrollment);
    }

    /**
     * Update the specified Enrollment in storage.
     *
     * @param  int              $id
     * @param UpdateEnrollmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEnrollmentRequest $request)
    {
        $enrollment = $this->enrollmentRepository->find($id);

        if (empty($enrollment)) {
            Flash::error('Enrollment not found');

            return redirect(route('enrollments.index'));
        }

        $enrollment = $this->enrollmentRepository->update($request->all(), $id);

        Flash::success('Enrollment updated successfully.');
        
        EnrollmentUpdated::dispatch($enrollment);
        return redirect(route('enrollments.index'));
    }

    /**
     * Remove the specified Enrollment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $enrollment = $this->enrollmentRepository->find($id);

        if (empty($enrollment)) {
            Flash::error('Enrollment not found');

            return redirect(route('enrollments.index'));
        }

        $this->enrollmentRepository->delete($id);

        Flash::success('Enrollment deleted successfully.');

        EnrollmentDeleted::dispatch($enrollment);
        return redirect(route('enrollments.index'));
    }
}
