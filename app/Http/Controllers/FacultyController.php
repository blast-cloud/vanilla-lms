<?php

namespace App\Http\Controllers;

use App\Events\DepartmentCreated;
use App\Events\DepartmentUpdated;
use App\Events\DepartmentDeleted;

use App\DataTables\FacultyDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class FacultyController extends AppBaseController
{
   
    public function index(FacultyDataTable $facultyDataTable)
    {
        return $facultyDataTable->render('faculties.index');
    }

    public function create()
    {
        return view('faculties.create');
    }

    
    public function store(CreateDepartmentRequest $request)
    {
        $is_parent = true;
        $input = array_merge(['is_parent' => $is_parent], $request->all());

        $faculty = Department::create($input);

        Flash::success('Faculty saved successfully.');
        
        DepartmentCreated::dispatch($faculty);
        return redirect(route('faculties.index'));
    }

    
    public function show($id)
    {
        $faculty = Department::where('parent_id', null)
                             ->where('is_parent', true)
                             ->find($id);
        
        if (empty($faculty)) {
            Flash::error('Faculty not found');

            return redirect(route('faculties.index'));
        }

        return view('faculties.show')->with('faculty', $faculty);
    }

    
    public function edit($id)
    {
        $faculty = Department::where('parent_id', null)
                             ->where('is_parent', true)
                             ->find($id);

        if (empty($faculty)) {
            Flash::error('Faculty not found');

            return redirect(route('faculties.index'));
        }

        return view('faculties.edit')->with('faculty', $faculty);
    }

    
    public function update($id, UpdateDepartmentRequest $request)
    {
        $faculty = Department::where('parent_id', null)
                             ->where('is_parent', true)
                             ->find($id);

        if (empty($faculty)) {
            Flash::error('Faculty not found');

            return redirect(route('faculties.index'));
        }

        $faculty->update($request->all());

        Flash::success('Faculty updated successfully.');
        
        DepartmentUpdated::dispatch($faculty);
        return redirect(route('faculties.index'));
    }

   
    public function destroy($id)
    {
        $faculty = Department::where('parent_id', null)
                            ->where('is_parent', true)
                            ->find($id);

        if (empty($faculty)) {
            Flash::error('Faculty not found');

            return redirect(route('faculties.index'));
        }

        $faculty->delete($id);

        Flash::success('Faculty deleted successfully.');

        DepartmentDeleted::dispatch($faculty);
        return redirect(route('faculties.index'));
    }
}
