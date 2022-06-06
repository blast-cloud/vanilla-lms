<?php

namespace App\Http\Controllers\API;

use Response;
use App\Http\Request;
use App\Http\Requests\API\CreateCourseClassFeedbackResponseAPIRequest;
use App\Http\Requests\API\UpdateCourseClassFeedbackResponseAPIRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\CourseClassFeedbackResponse;
use App\Http\Resources\CourseClassFeedbackResponseResource;

class CourseClassFeedbackResponseAPIController extends AppBaseController
{
 
    public function store(CreateCourseClassFeedbackResponseAPIRequest $request)
    {
        $input = $request->all();

        $courseClassFeedbackResponse = CourseClassFeedbackResponse::create($input);
        return $this->sendResponse(new CourseClassFeedbackResponseResource($courseClassFeedbackResponse), 'Course Class Feedback Saved Successfully.');
    }

   
    public function show($id)
    {
        $courseClassFeedbackResponse = CourseClassFeedbackResponse::find($id);

        if(empty($courseClassFeedbackResponse)){
            return $this->sendError('Course Class Feedback Response not Found.');
        }
        return $this->sendResponse(new CourseClassFeedbackResponseResource($courseClassFeedbackResponse), 'Course Class Feedback Response retrieved successfully.');
    }
    
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $courseClassFeedbackResponse = CourseClassFeedbackResponse::find($id);

        if(empty($courseClassFeedbackResponse)){
            return $this->sendError('Course Class Feedback Response not Found.');
        }

        $courseClassFeedbackResponse->update($input);
        return $this->sendResponse(new CourseClassFeedbackResponseResource($courseClassFeedbackResponse), 'Course Class Feedback Updated Successfully.');
    }

   
    public function destroy($id)
    {
        $courseClassFeedbackResponse = CourseClassFeedbackResponse::find($id);

        if (empty($courseClassFeedbackResponse)) {
            return $this->sendError('Course Class Feedback Response not Found.');
        }

        $courseClassFeedbackResponse->delete();
        return $this->sendResponse($courseClassFeedbackResponse,'Course Class Feedback Response Deleted Successfully.');
    }
}
