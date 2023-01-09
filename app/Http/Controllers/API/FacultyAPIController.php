<?php

namespace App\Http\Controllers\API;

use App\Events\DepartmentCreated;
use App\Events\DepartmentUpdated;
use App\Events\DepartmentDeleted;

use App\Http\Requests\API\CreateDepartmentAPIRequest;
use App\Http\Requests\API\UpdateDepartmentAPIRequest;
use App\Http\Requests\API\BulkFacultyApiRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\DepartmentResource;
use Response;

class FacultyAPIController extends AppBaseController
{

    public function index(Request $request)
    {
        $faculties = Department::where('is_parent', true)
                                ->where('parent_id', null)->all(
                                    $request->except(['skip', 'limit']),
                                    $request->get('skip'),
                                    $request->get('limit')
                                );

        return $this->sendResponse(DepartmentResource::collection($faculties), 'Faculties retrieved successfully');
    }

    public function store(CreateDepartmentAPIRequest $request)
    {
        $parent_id = true;

        $input = array_merge(['parent_id' => $parent_id], $request->all());

        $faculty = Department::create($input);
        
        DepartmentCreated::dispatch($faculty);
        return $this->sendResponse(new DepartmentResource($faculty), 'Faculty saved successfully');
    }

    public function show($id)
    {
        $faculty = Department::where('parent_id', null)
                            ->where('is_parent', true)
                            ->find($id);

        if (empty($faculty)) {
            return $this->sendError('Faculty not found');
        }

        return $this->sendResponse(new DepartmentResource($faculty), 'Faculty retrieved successfully');
    }

    public function update($id, UpdateDepartmentAPIRequest $request)
    {
        $input = $request->all();

        $faculty = Department::where('parent_id', null)
                            ->where('is_parent', true)
                            ->find($id);

        if (empty($faculty)) {
            return $this->sendError('Faculty not found');
        }

        $faculty = $faculty->update($input);
        
        DepartmentUpdated::dispatch($faculty);
        return $this->sendResponse(new DepartmentResource($faculty), 'Faculty updated successfully');
    }

    public function destroy($id)
    {    
        $faculty = Department::where('parent_id', null)
                            ->where('is_parent', true)
                            ->find($id);

        if (empty($faculty)) {
            return $this->sendError('Faculty not found');
        }

        $faculty->delete();
        DepartmentDeleted::dispatch($faculty);
        return $this->sendSuccess('Faculty deleted successfully');
    }

    public function uploadBulkFaculty(BulkFacultyApiRequest $request)
    {
        $extension = $request->file('bulk_faculty_file')->getClientOriginalExtension();
        $attachedFileName = time() . '.' . $extension;
        $request->file('bulk_faculty_file')->move(public_path('uploads'), $attachedFileName);
        $path_to_file = public_path('uploads').'/'.$attachedFileName;

        $errors = [];
        $loop = 1;
        $lines = file($path_to_file);
        if (count($lines) > 1) {
            foreach ($lines as $line) {
                // skip first line (heading line)
                if ($loop > 1) {
                    $data = explode(',', $line);
                    // dd($data);
                    $invalids = $this->validateValues($data);
                  if (count($invalids) > 0) {
                    array_push($errors, $invalids);
                    continue;
                  }else{
                    $faculty_data = array_merge($request->input(), [
                    'code' => trim($data[0]),
                    'name' => trim($data[1])
                  ]);     
                    $faculty = Department::create($faculty_data); 
                    DepartmentCreated::dispatch($faculty);
                  }
                }else{
                    $headers = explode(',', $line);
                    if (count($headers) != 2 || strtolower(trim($headers[0])) != 'code' || strtolower(trim($headers[1])) != 'name' || isset($headers[2])) {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "code,name"';
                        array_push($errors, $invalids);
                        break;
                    }
                }
                $loop++;
            }
        }else{
            $errors[] = 'The uploaded csv file is empty';
        }

        if (count($errors) > 0) {
            return response()->json(['errors' => $this->array_flatten($errors)]);
        }
        return true;
    }

    public function validateValues($data)
    {
        $errors = [];

        $faculty = Department::where('is_parent',true)->where('parent_id',null)->where('code', trim($data[0]))->first();
        if ($faculty) {
            $errors[] = 'The code: '.trim($data[0]).' already belongs to a faculty';
        }
        return $errors;
    }

    public function array_flatten($array) {

       $return = array();
       foreach ($array as $key => $value) {
           if (is_array($value)){ $return = array_merge($return, $this->array_flatten($value));}
           else {$return[$key] = $value;}
       }
       return $return;
    }
}
