<?php

namespace App\Http\Controllers;

use App\Events\DepartmentCreated;
use App\Events\DepartmentUpdated;
use App\Events\DepartmentDeleted;

use App\DataTables\DepartmentDataTable;
use App\Http\Requests;
use App\Models\Department;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Repositories\DepartmentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class DepartmentController extends AppBaseController
{
    /** @var  DepartmentRepository */
    private $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepository = $departmentRepo;
    }

    /**
     * Display a listing of the Department.
     *
     * @param DepartmentDataTable $departmentDataTable
     * @return Response
     */
    public function facultyDepts(DepartmentDataTable $departmentDataTable, $faculty_id)
    {
        $faculty = Department::where('parent_id',null)
                             ->where('is_parent',true)
                             ->find($faculty_id);
                             
        $faculties = Department::where('parent_id',null)
                                ->where('is_parent', true)
                                ->select('id','name')
                                ->get();

        return $departmentDataTable->render('departments.index', compact('faculty','faculties'));
    }

    public function index(DepartmentDataTable $departmentDataTable)
    {
        return $departmentDataTable->render('departments.index');
    }

    /**
     * Show the form for creating a new Department.
     *
     * @return Response
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created Department in storage.
     *
     * @param CreateDepartmentRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartmentRequest $request)
    {
        $is_parent = false;

        $input = array_merge(['is_parent' => $is_parent], $request->all());

        $department = Department::create($input);

        Flash::success('Department saved successfully.');
        
        DepartmentCreated::dispatch($department);
        return redirect()->back();
    }

    /**
     * Display the specified Department.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $department = Department::where('parent_id', '!=', null)
                                 ->where('is_parent', false)
                                 ->find($id);

        if (empty($department)) {
            Flash::error('Department not found');

            return redirect()->back();
        }

        return view('departments.show')->with('department', $department);
    }

    /**
     * Show the form for editing the specified Department.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $department = Department::where('parent_id', '!=', null)
                                 ->where('is_parent', false)
                                 ->find($id);

        if (empty($department)) {
            Flash::error('Department not found');

            return redirect()->back();
        }

        return view('departments.edit')->with('department', $department);
    }

    /**
     * Update the specified Department in storage.
     *
     * @param  int              $id
     * @param UpdateDepartmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartmentRequest $request)
    {
        $department = Department::where('parent_id', '!=', null)
                                 ->where('is_parent', false)
                                 ->find($id);

        if (empty($department)) {
            Flash::error('Department not found');

            return redirect()->back();
        }

        $department->update($request->all());

        Flash::success('Department updated successfully.');
        
        DepartmentUpdated::dispatch($department);
        return redirect()->back();
    }

    /**
     * Remove the specified Department from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $department = Department::where('parent_id', '!=', null)
                                 ->where('is_parent', false)
                                 ->find($id);

        if (empty($department)) {
            Flash::error('Department not found');

            return redirect()->back();
        }

        $department->delete($id);

        Flash::success('Department deleted successfully.');

        DepartmentDeleted::dispatch($department);
        return redirect()->back();
    }
}
