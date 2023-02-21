<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DataTables\SemesterMaxCreditLoadDataTable;

use App\Http\Requests\CreateSemesterMaxCreditLoadRequest;
use App\Http\Requests\UpdateSemesterMaxCreditLoadRequest;
use App\Repositories\SemesterMaxCreditLoadRepository;
use Flash;
use Response;
use App\Models\SemesterMaxCreditLoad;
use App\Http\Resources\SemesterMaxCreditLoadResource;

use App\Http\Controllers\AppBaseController;

class SemesterMaxCreditLoadController extends AppBaseController
{
     /** @var  SemesterMaxCreditLoadRepository */
     private $semesterMaxCreditLoadRepository;

    public function __construct(SemesterMaxCreditLoadRepository $semesterMaxCreditLoadRepo)
    {
        $this->$semesterMaxCreditLoadRepository = $semesterMaxCreditLoadRepo;
    }

    public function index(SemesterMaxCreditLoadDataTable $semesterMaxCreditLoadDataTable)
    {
        return $semesterMaxCreditLoadDataTable->render('credit_loads.index');
    }

    public function create()
    {
        return view('credit_loads.create');
    }

    public function store(CreateSemesterMaxCreditLoadRequest $request)
    {
        $input = $request->all();

        $semesterMaxCreditLoad = $this->semesterMaxCreditLoadRepository->create($input);

        Flash::success('SemesterMaxCreditLoad saved successfully.');
        
        return redirect(route('credit_loads.index'));
    }

    public function show($id)
    {
        $semesterMaxCreditLoad = $this->semesterMaxCreditLoadRepository->find($id);

        if (empty($semesterMaxCreditLoad)) {
            return $this->sendError('SemesterMaxCreditLoad not found');
        }

        return view('credit_loads.show')->with('semesterMaxCreditLoad',$semesterMaxCreditLoad);
    }

    public function edit($id)
    {
        $semesterMaxCreditLoad = $this->semesterMaxCreditLoadRepository->find($id);

        if (empty($semesterMaxCreditLoad)) {
            return $this->sendError('SemesterMaxCreditLoad not found');
        }

        return view('credit_loads.edit')->with('semesterMaxCreditLoad',$semesterMaxCreditLoad);
    }

    public function update($id, UpdateSemesterMaxCreditLoadRequest $request)
    {
        $semesterMaxCreditLoad = $this->semesterMaxCreditLoadRepository->find($id);

        if (empty($semesterMaxCreditLoad)) {
            Flash::error('SemesterMaxCreditLoad not found');

            return redirect(route('credit_loads.index'));
        }

        $semesterMaxCreditLoad = $this->semesterMaxCreditLoadRepository->update($request->all());

        Flash::success('SemesterMaxCreditLoad updated successfully.');
        
        return redirect(route('credit_loads.index'));
    }

    public function destroy($id)
    {
        $semesterMaxCreditLoad = $this->semesterMaxCreditLoadRepository->find($id);

        if (empty($semesterMaxCreditLoad)) {
            Flash::error('SemesterMaxCreditLoad not found');

            return redirect(route('credit_loads.index'));
        }

        $this->semesterMaxCreditLoadRepository->delete($id);

        Flash::success('SemesterMaxCreditLoad deleted successfully.');

        return redirect(route('credit_loads.index'));
    }
}
