<?php

namespace App\Http\Controllers;

use App\Events\LecturerCreated;
use App\Events\LecturerUpdated;
use App\Events\LecturerDeleted;

use App\DataTables\LecturerDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLecturerRequest;
use App\Http\Requests\UpdateLecturerRequest;
use App\Repositories\LecturerRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class LecturerController extends AppBaseController
{
    /** @var  LecturerRepository */
    private $lecturerRepository;

    public function __construct(LecturerRepository $lecturerRepo)
    {
        $this->lecturerRepository = $lecturerRepo;
    }

    /**
     * Display a listing of the Lecturer.
     *
     * @param LecturerDataTable $lecturerDataTable
     * @return Response
     */
    public function index(LecturerDataTable $lecturerDataTable)
    {
        return $lecturerDataTable->render('lecturers.index');
    }

    /**
     * Show the form for creating a new Lecturer.
     *
     * @return Response
     */
    public function create()
    {
        return view('lecturers.create');
    }

    /**
     * Store a newly created Lecturer in storage.
     *
     * @param CreateLecturerRequest $request
     *
     * @return Response
     */
    public function store(CreateLecturerRequest $request)
    {
        $input = $request->all();

        $lecturer = $this->lecturerRepository->create($input);

        Flash::success('Lecturer saved successfully.');
        
        LecturerCreated::dispatch($lecturer);
        return redirect(route('lecturers.index'));
    }

    /**
     * Display the specified Lecturer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $lecturer = $this->lecturerRepository->find($id);

        if (empty($lecturer)) {
            Flash::error('Lecturer not found');

            return redirect(route('lecturers.index'));
        }

        return view('lecturers.show')->with('lecturer', $lecturer);
    }

    /**
     * Show the form for editing the specified Lecturer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $lecturer = $this->lecturerRepository->find($id);

        if (empty($lecturer)) {
            Flash::error('Lecturer not found');

            return redirect(route('lecturers.index'));
        }

        return view('lecturers.edit')->with('lecturer', $lecturer);
    }

    /**
     * Update the specified Lecturer in storage.
     *
     * @param  int              $id
     * @param UpdateLecturerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLecturerRequest $request)
    {
        $lecturer = $this->lecturerRepository->find($id);

        if (empty($lecturer)) {
            Flash::error('Lecturer not found');

            return redirect(route('lecturers.index'));
        }

        $lecturer = $this->lecturerRepository->update($request->all(), $id);

        Flash::success('Lecturer updated successfully.');
        
        LecturerUpdated::dispatch($lecturer);
        return redirect(route('lecturers.index'));
    }

    /**
     * Remove the specified Lecturer from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $lecturer = $this->lecturerRepository->find($id);

        if (empty($lecturer)) {
            Flash::error('Lecturer not found');

            return redirect(route('lecturers.index'));
        }

        $this->lecturerRepository->delete($id);

        Flash::success('Lecturer deleted successfully.');

        LecturerDeleted::dispatch($lecturer);
        return redirect(route('lecturers.index'));
    }
}
