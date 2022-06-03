<?php

namespace App\Http\Controllers\API;
use App\Repositories\CourseClassFeedbackResponseRepository;

use Response;
use App\Http\Request;
use App\Http\Requests\API\CreateCourseClassFeedbackResponseAPIRequest;
use App\Http\Requests\API\UpdateCourseClassFeedbackResponseAPIRequest;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CourseClassFeedbackResponseResource;
use App\Models\CourseClassFeedbackResponse;

class CourseClassFeedbackResponseAPIController extends AppBaseController
{
   
    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

   
    public function store(CreateCourseClassFeedbackResponseAPIRequest $request)
    {
        $input = $request->all();

        $courseClassFeedbackResponse = CourseClassFeedbackResponse::create($input);
        return $this->sendResponse(new CourseClassFeedbackResponseResource($courseClassFeedbackResponse), 'Course Class Feedback Saved Successfully.');
    }

   
    public function show($id)
    {
        $courseClassFeedbackResponse = $this->courseClassFeedbackResponseRepository->find($id);

        if(empty($courseClassFeedbackResponse)){
            return $this->sendError('Course Class Feedback Response not Found.');
        }

        return $this->sendResponse(new CourseClassFeedbackResponseResource($courseClassFeedbackResponse), 'Course Class Feedback Response retrieved successfully.');
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $courseClassFeedbackResponse = $this->courseClassFeedbackResponseRepository->find($id);

        if(empty($courseClassFeedbackResponse)){
            return $this->sendError('Course Class Feedback Response not Found.');
        }

        $courseClassFeedbackResponse = $this->courseClassFeedbackResponseRepository->update($input, $id);
        return $this->sendResponse(new CourseClassFeedbackResponseResource($courseClassFeedbackResponse), 'Course Class Feedback Updated Successfully.');
    }

   
    public function destroy($id)
    {
        $courseClassFeedbackResponse = $this->courseClassFeedbackResponseRepository->find($id);

        if (empty($courseClassFeedbackResponse)) {
            return $this->sendError('Course Class Feedback Response not Found.');
        }

        $courseClassFeedbackResponse->delete();
        return $this->sendResponse($courseClassFeedbackResponse,'Course Class Feedback Response Deleted Successfully.');
    }
}
