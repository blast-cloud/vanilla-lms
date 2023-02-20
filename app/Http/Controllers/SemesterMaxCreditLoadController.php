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

class SemesterMaxCreditLoadController extends Controller
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
        //
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
