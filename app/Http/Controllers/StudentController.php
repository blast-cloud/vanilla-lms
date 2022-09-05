<?php

namespace App\Http\Controllers;

use App\Events\StudentCreated;
use App\Events\StudentUpdated;
use App\Events\StudentDeleted;

use App\DataTables\StudentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Repositories\StudentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Http;

class StudentController extends AppBaseController
{
    /** @var  StudentRepository */
    private $studentRepository;

    public function __construct(StudentRepository $studentRepo)
    {
        $this->studentRepository = $studentRepo;
    }

    /**
     * Display a listing of the Student.
     *
     * @param StudentDataTable $studentDataTable
     * @return Response
     */
    public function index(StudentDataTable $studentDataTable)
    {
        return $studentDataTable->render('students.index');
    }

    /**
     * Show the form for creating a new Student.
     *
     * @return Response
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created Student in storage.
     *
     * @param CreateStudentRequest $request
     *
     * @return Response
     */
    public function store(CreateStudentRequest $request)
    {
        $bims_data = [
            'client_id' => env('BIMS_CLIENT_ID'),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->telephone,
            'gender' => "M"
        ];

        if ($request->sex == 'Male') {
            $bims_data['gender'] = "M";
        } else {
            $bims_data['gender'] = "F";
        }

        $register_for_bims = Http::acceptJson()->post(env('BIMS_CREATE_USER_URL'), $bims_data);

        $input = $request->all();

        $student = $this->studentRepository->create($input);

        Flash::success('Student saved successfully.');
        
        StudentCreated::dispatch($student);
        return redirect(route('students.index'));
    }

    /**
     * Display the specified Student.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $student = $this->studentRepository->find($id);

        if (empty($student)) {
            Flash::error('Student not found');

            return redirect(route('students.index'));
        }

        return view('students.show')->with('student', $student);
    }

    /**
     * Show the form for editing the specified Student.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $student = $this->studentRepository->find($id);

        if (empty($student)) {
            Flash::error('Student not found');

            return redirect(route('students.index'));
        }

        return view('students.edit')->with('student', $student);
    }

    /**
     * Update the specified Student in storage.
     *
     * @param  int              $id
     * @param UpdateStudentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStudentRequest $request)
    {
        $bims_data = [
            'client_id' => env('BIMS_CLIENT_ID'),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->telephone,
            'gender' => "M"
        ];

        if ($request->sex == 'Male') {
            $bims_data['gender'] = "M";
        } else {
            $bims_data['gender'] = "F";
        }

        $register_for_bims = Http::acceptJson()->post(env('BIMS_CREATE_USER_URL'), $bims_data);
        
        $student = $this->studentRepository->find($id);

        if (empty($student)) {
            Flash::error('Student not found');

            return redirect(route('students.index'));
        }

        $student = $this->studentRepository->update($request->all(), $id);

        Flash::success('Student updated successfully.');
        
        StudentUpdated::dispatch($student);
        return redirect(route('students.index'));
    }

    /**
     * Remove the specified Student from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $student = $this->studentRepository->find($id);

        if (empty($student)) {
            Flash::error('Student not found');

            return redirect(route('students.index'));
        }

        $this->studentRepository->delete($id);

        Flash::success('Student deleted successfully.');

        StudentDeleted::dispatch($student);
        return redirect(route('students.index'));
    }
}
