<?php

namespace App\Http\Controllers;

use App\Events\CourseClassCreated;
use App\Events\CourseClassUpdated;
use App\Events\CourseClassDeleted;

use App\DataTables\CourseClassDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCourseClassRequest;
use App\Http\Requests\UpdateCourseClassRequest;
use App\Http\Requests\UpdateCourseClassOutlineRequest;
use App\Repositories\CourseClassRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CourseClassController extends AppBaseController
{
    /** @var  CourseClassRepository */
    private $courseClassRepository;

    public function __construct(CourseClassRepository $courseClassRepo)
    {
        $this->courseClassRepository = $courseClassRepo;
    }

    /**
     * Display a listing of the CourseClass.
     *
     * @param CourseClassDataTable $courseClassDataTable
     * @return Response
     */
    public function index(CourseClassDataTable $courseClassDataTable)
    {
        return $courseClassDataTable->render('course_classes.index');
    }

    /**
     * Show the form for creating a new CourseClass.
     *
     * @return Response
     */
    public function create()
    {
        return view('course_classes.create');
    }

    /**
     * Store a newly created CourseClass in storage.
     *
     * @param CreateCourseClassRequest $request
     *
     * @return Response
     */
    public function store(CreateCourseClassRequest $request)
    {
        $input = $request->all();

        $courseClass = $this->courseClassRepository->create($input);

        Flash::success('Course Class saved successfully.');
        
        CourseClassCreated::dispatch($courseClass);
        return redirect(route('courseClasses.index'));
    }

    /**
     * Display the specified CourseClass.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $courseClass = $this->courseClassRepository->find($id);

        if (empty($courseClass)) {
            Flash::error('Course Class not found');

            return redirect(route('courseClasses.index'));
        }

        return view('course_classes.show')->with('courseClass', $courseClass);
    }

    /**
     * Show the form for editing the specified CourseClass.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $courseClass = $this->courseClassRepository->find($id);

        if (empty($courseClass)) {
            Flash::error('Course Class not found');

            return redirect(route('courseClasses.index'));
        }

        return view('course_classes.edit')->with('courseClass', $courseClass);
    }

    /**
     * Update the specified CourseClass in storage.
     *
     * @param  int              $id
     * @param UpdateCourseClassRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCourseClassRequest $request)
    {
        $courseClass = $this->courseClassRepository->find($id);

        if (empty($courseClass)) {
            Flash::error('Course Class not found');

            return redirect(route('courseClasses.index'));
        }

        $courseClass = $this->courseClassRepository->update($request->all(), $id);

        Flash::success('Course Class updated successfully.');
        
        CourseClassUpdated::dispatch($courseClass);
        return redirect(route('courseClasses.index'));
    }

    /**
     * Update the specified CourseClass in storage.
     *
     * @param  int              $id
     * @param UpdateCourseClassOutlineRequest $request
     *
     * @return Response
     */
    public function updateCourseClassOutline($id, UpdateCourseClassOutlineRequest $request)
    {
        $courseClass = $this->courseClassRepository->find($id);

        if (empty($courseClass)) {
            Flash::error('Course Class not found');

            return redirect(route('courseClasses.index'));
        }

        $courseClass = $this->courseClassRepository->update($request->all(), $id);

        Flash::success('Course Class Outline updated successfully.');
        
        CourseClassUpdated::dispatch($courseClass);
        return redirect(route('courseClasses.index'));
    }

    /**
     * Remove the specified CourseClass from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $courseClass = $this->courseClassRepository->find($id);

        if (empty($courseClass)) {
            Flash::error('Course Class not found');

            return redirect(route('courseClasses.index'));
        }

        $this->courseClassRepository->delete($id);

        Flash::success('Course Class deleted successfully.');

        CourseClassDeleted::dispatch($courseClass);
        return redirect(route('courseClasses.index'));
    }
}
