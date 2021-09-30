<?php

namespace App\Http\Controllers;

use App\Events\ClassMaterialCreated;
use App\Events\ClassMaterialUpdated;
use App\Events\ClassMaterialDeleted;

use App\DataTables\ClassMaterialDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateClassMaterialRequest;
use App\Http\Requests\UpdateClassMaterialRequest;
use App\Repositories\ClassMaterialRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Semester;
use App\Models\ClassMaterial;

class ClassMaterialController extends AppBaseController
{
    /** @var  ClassMaterialRepository */
    private $classMaterialRepository;

    public function __construct(ClassMaterialRepository $classMaterialRepo)
    {
        $this->classMaterialRepository = $classMaterialRepo;
    }

    /**
     * Display a listing of the ClassMaterial.
     *
     * @param ClassMaterialDataTable $classMaterialDataTable
     * @return Response
     */
    public function index(ClassMaterialDataTable $classMaterialDataTable)
    {
        return $classMaterialDataTable->render('class_materials.index');
    }

    /**
     * Show the form for creating a new ClassMaterial.
     *
     * @return Response
     */
    public function create()
    {
        return view('class_materials.create');
    }

    /**
     * Store a newly created ClassMaterial in storage.
     *
     * @param CreateClassMaterialRequest $request
     *
     * @return Response
     */
    public function store(CreateClassMaterialRequest $request)
    {
        if ($this->assignmnetExists($request->assignment_number)) {
            $error = ['exists'=>'An assignment with this lecture number already exists this semester'];
            return response()->json(['errors'=>$error]);
        }

        $input = array_merge($request->all(), ['semester_id'=>$current_semester->id]);

        $classMaterial = $this->classMaterialRepository->create($input);

        Flash::success('Class Material saved successfully.');
        
        ClassMaterialCreated::dispatch($classMaterial);
        return redirect(route('classMaterials.index'));
    }

    /**
     * Display the specified ClassMaterial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $classMaterial = $this->classMaterialRepository->find($id);

        if (empty($classMaterial)) {
            Flash::error('Class Material not found');

            return redirect(route('classMaterials.index'));
        }

        return view('class_materials.show')->with('classMaterial', $classMaterial);
    }

    /**
     * Show the form for editing the specified ClassMaterial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $classMaterial = $this->classMaterialRepository->find($id);

        if (empty($classMaterial)) {
            Flash::error('Class Material not found');

            return redirect(route('classMaterials.index'));
        }

        return view('class_materials.edit')->with('classMaterial', $classMaterial);
    }

    /**
     * Update the specified ClassMaterial in storage.
     *
     * @param  int              $id
     * @param UpdateClassMaterialRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateClassMaterialRequest $request)
    {
        $classMaterial = $this->classMaterialRepository->find($id);

        if (empty($classMaterial)) {
            Flash::error('Class Material not found');

            return redirect(route('classMaterials.index'));
        }

        $classMaterial = $this->classMaterialRepository->update($request->all(), $id);

        Flash::success('Class Material updated successfully.');
        
        ClassMaterialUpdated::dispatch($classMaterial);
        return redirect(route('classMaterials.index'));
    }

    /**
     * Remove the specified ClassMaterial from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $classMaterial = $this->classMaterialRepository->find($id);

        if (empty($classMaterial)) {
            Flash::error('Class Material not found');

            return redirect(route('classMaterials.index'));
        }

        $this->classMaterialRepository->delete($id);

        Flash::success('Class Material deleted successfully.');

        ClassMaterialDeleted::dispatch($classMaterial);
        return redirect(route('classMaterials.index'));
    }

    public function assignmnetExists($assignment_number)
    {
        $current_semester = Semester::where('is_current', true)->first();

        return ClassMaterial::where('type', 'class-assignments')
                                ->where('semester_id', $current_semester->id)
                                ->where('assignment_number', $assignment_number)
                                ->first();
    }
}
