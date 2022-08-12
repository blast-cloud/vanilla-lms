<?php

namespace App\Http\Controllers;

use App\Events\SemesterCreated;
use App\Events\SemesterUpdated;
use App\Events\SemesterDeleted;

use App\DataTables\SemesterDataTable;
use App\DataTables\SemesterNotificationsDatatable;
use App\DataTables\SemesterOfferedCoursesDatatable;

use App\Http\Requests\CreateSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Http\Requests\CommenceSemesterRequest;
use App\Repositories\SemesterRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Semester;
use App\Http\Resources\SemesterResource;
use Illuminate\Http\Request;

class SemesterController extends AppBaseController
{
    /** @var  SemesterRepository */
    private $semesterRepository;

    public function __construct(SemesterRepository $semesterRepo)
    {
        $this->semesterRepository = $semesterRepo;
    }

    /**
     * Display a listing of the Semester.
     *
     * @param SemesterDataTable $semesterDataTable
     * @return Response
     */
    public function index(SemesterDataTable $semesterDataTable)
    {
        $allSemesters = $this->getAllSemesters();
        return $semesterDataTable->render('semesters.index', ['allSemesters' => $allSemesters]);
    }

    /**
     * Show the form for creating a new Semester.
     *
     * @return Response
     */
    public function create()
    {
        return view('semesters.create');
    }

    /**
     * Store a newly created Semester in storage.
     *
     * @param CreateSemesterRequest $request
     *
     * @return Response
     */
    public function store(CreateSemesterRequest $request)
    {
        $input = $request->all();

        $semester = $this->semesterRepository->create($input);

        Flash::success('Semester saved successfully.');
        
        SemesterCreated::dispatch($semester);
        return redirect(route('semesters.index'));
    }

    /**
     * Display the specified Semester.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(SemesterOfferedCoursesDatatable $SemesterOfferedCoursesDatatable, SemesterNotificationsDatatable $SemesterNotificationsDatatable, $id)
    {
         /** @var Semester $semester */
        $semester = $this->semesterRepository->find($id);
        
        $current_semester = Semester::where('is_current', 1)->first();

        if (empty($semester)) {
            return redirect(route('semesters.index'))->with('error', 'Semester not found');
        }
        if (request()->has('offeredclasses')) {
            return $SemesterOfferedCoursesDatatable->with('semester_id', $semester->id)->render('semesters.show', ['semester' => $semester, 'current_semester' => $current_semester, ]);
        } elseif (request()->has('notifications')) {
            return $SemesterNotificationsDatatable->with('semester_id', $semester->id)->render('semesters.show', ['semester' => $semester, 'current_semester' => $current_semester, ]);
        }
        return $SemesterOfferedCoursesDatatable->with('semester_id', $semester->id)->render('semesters.show', ['semester' => $semester, 'current_semester' => $current_semester, ]);
    }

    /**
     * Show the form for editing the specified Semester.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
         /** @var Semester $semester */
        $semester = $this->semesterRepository->find($id);

        if (!empty($semester)) {
            return $this->sendError('Semester not found');
        }
        
        return $this->sendResponse(new SemesterResource($semester), 'Semester retrieved successfully');
    }

    /**
     * Update the specified Semester in storage.
     *
     * @param  int              $id
     * @param UpdateSemesterRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSemesterRequest $request)
    {
        $semester = $this->semesterRepository->find($id);

        if (empty($semester)) {
            Flash::error('Semester not found');

            return redirect(route('semesters.index'));
        }

        $semester = $this->semesterRepository->update($request->all(), $id);

        Flash::success('Semester updated successfully.');
        
        SemesterUpdated::dispatch($semester);
        return redirect(route('semesters.index'));
    }

    /**
     * Remove the specified Semester from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $semester = $this->semesterRepository->find($id);

        if (empty($semester)) {
            Flash::error('Semester not found');

            return redirect(route('semesters.index'));
        }

        $this->semesterRepository->delete($id);

        Flash::success('Semester deleted successfully.');

        SemesterDeleted::dispatch($semester);
        return redirect(route('semesters.index'));
    }

    public function getAllSemesters()
    {
        $allSemesters = Semester::where('is_current', '!=', 1)->orWhereNull('is_current')->orderBy('academic_session', 'desc')->get();
        return $allSemesters;
        //return $this->sendResponse($allSemesters, 'Semesters retrieved successfully');
    }

    public function setCurrentSemester(CommenceSemesterRequest $request)
    {
        $allData = $request->all();
        $findSemester = $this->semesterRepository->find($allData['is_current']);

        if (empty($findSemester)) {
            return $this->sendError('Semester not found');
        }

        //updating current semester
        $updateResult = $findSemester->update(['is_current' => 1, 'status' => '1']);

        //unsetting initial current semesters
        $ObjSemester = new Semester();
        $unSettingResult = $ObjSemester->where('is_current', '1')->where('status', '1')->where('id', '!=', $findSemester->id )->update(['is_current' => 0, 'status' => '0']);

        return $this->sendResponse($findSemester, 'Semester retrieved successfully');      
    }
}
