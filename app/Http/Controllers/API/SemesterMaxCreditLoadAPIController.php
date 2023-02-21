<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSemesterMaxCreditLoadAPIRequest;
use App\Http\Requests\API\UpdateSemesterMaxCreditLoadAPIRequest;
use App\Models\SemesterMaxCreditLoad;
use App\Repositories\SemesterMaxCreditLoadRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\SemesterMaxCreditLoadResource;
use Illuminate\Http\Request;
use Response;

class SemesterMaxCreditLoadAPIController extends AppBaseController
{
    /** @var  SemesterMaxCreditLoadRepository */
    private $semesterMaxCreditLoadRepository;

    public function __construct(SemesterMaxCreditLoadRepository $semesterMaxCreditLoadRepo)
    {
        $this->semesterMaxCreditLoadRepository = $semesterMaxCreditLoadRepo;
    }


    public function store(CreateSemesterMaxCreditLoadAPIRequest $request)
    {
        $input = $request->all();

        $semesterMaxCreditLoad = $this->semesterMaxCreditLoadRepository->create($input);
        
        return $this->sendResponse(new SemesterMaxCreditLoadResource($semesterMaxCreditLoad), 'SemesterMaxCreditLoad saved successfully');
    }

    public function show($id)
    {
        $semesterMaxCreditLoad = $this->semesterMaxCreditLoadRepository->find($id);

        if (empty($semesterMaxCreditLoad)) {
            return $this->sendError('SemesterMaxCreditLoad not found');
        }

        return $this->sendResponse(new SemesterMaxCreditLoadResource($semesterMaxCreditLoad), 'SemesterMaxCreditLoad retrieved successfully');
    }

    public function update($id, UpdateSemesterMaxCreditLoadAPIRequest $request)
    {
        $input = $request->all();

        $semesterMaxCreditLoad = $this->semesterMaxCreditLoadRepository->find($id);

        if (empty($semesterMaxCreditLoad)) {
            return $this->sendError('SemesterMaxCreditLoad not found');
        }

        $semesterMaxCreditLoad = $this->semesterMaxCreditLoadRepository->update($input, $id);
        
        return $this->sendResponse(new SemesterMaxCreditLoadResource($semesterMaxCreditLoad), 'SemesterMaxCreditLoad updated successfully');
    }

    public function destroy($id)
    {
        $semesterMaxCreditLoad = $this->semesterMaxCreditLoadRepository->find($id);

        if (empty($semesterMaxCreditLoad)) {
            return $this->sendError('SemesterMaxCreditLoad not found');
        }

        $semesterMaxCreditLoad->delete();
        return $this->sendSuccess('SemesterMaxCreditLoad deleted successfully');
    }
}
