<?php

namespace App\Http\Controllers\API;

use App\Repositories\CourseClassFeedbackRepository;

use Response;
use App\Http\Request;
use App\Http\Requests\API\CreateCourseClassFeedbackAPIRequest;
use App\Http\Requests\API\UpdateCourseClassFeedbackAPIRequest;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CourseClassFeedbackResource;
use App\Models\CourseClassFeedback;

class CourseClassFeedbackAPIController extends AppBaseController
{
    /** @var  CourseClassFeedbackRepository */
    private $courseClassFeedbackRepository;

    public function __construct(CourseClassFeedbackRepository $courseClassFeedbackRepo)
    {
        $this->courseClassFeedbackRepository = $courseClassFeedbackRepo;
    }
  
    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

    
    public function store(CreateCourseClassFeedbackAPIRequest $request)
    {
        $input = $request->all();

        $courseClassFeedback = CourseClassFeedback::create($input);
        return $this->sendResponse(new CourseClassFeedbackResource($courseClassFeedback), 'Course Class Feedback Saved Successfully.');

    }

    
    public function show($id)
    {
        $courseClassFeedback = $this->courseClassFeedbackRepository->find($id);

        if(empty($courseClassFeedback)){
            return $this->sendError('Course Class Feedback not Found.');
        }

        return $this->sendResponse(new CourseClassFeedbackResource($courseClassFeedback), 'Course Class Feedback retrieved successfully.');
      
    }

    
    public function edit($id)
    {

    }

    
    public function update(UpdateCourseClassFeedbackAPIRequest $request, $id)
    {
        $input = ['start_date' => $request->start_date,'end_date' => $request->end_date, 'note' => $request->note ];

        $courseClassFeedback = $this->courseClassFeedbackRepository->find($id);

        if(empty($courseClassFeedback)){
            return $this->sendError('Course Class Feedback not Found.');
        }
        $courseClassFeedback = $this->courseClassFeedbackRepository->update($input, $id);
        return $this->sendResponse(new CourseClassFeedbackResource($courseClassFeedback), 'Course Class Feedback Updated Successfully.');
        
    }

    
    public function destroy($id)
    {
        $courseClassFeedback = $this->courseClassFeedbackRepository->find($id);

        if (empty($courseClassFeedback)) {
            return $this->sendError('Course Class Feedback not Found.');
        }

        $courseClassFeedback->delete();
        return $this->sendResponse($courseClassFeedback, 'Course Class Feedback Deleted Successfully.');
        
    }
}
