<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Http\Request;
use App\Http\Requests\CreateCourseClassFeedbackResponseRequest;
use App\Http\Requests\UpdateCourseClassFeedbackResponseRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\CourseClassFeedbackResponse;
use App\Models\CourseClassFeedback;
use App\Models\CourseClass;
use App\Models\Semester;

class CourseClassFeedbackResponseController extends AppBaseController
{
  
    public function store(CreateCourseClassFeedbackResponseRequest $request)
    {
        $current_user = Auth()->user();
        $student_id = $current_user->student_id;
        $input = array_merge($request->all(), ['student_id'=>$student_id]);

        $courseClassFeedbackResponse = CourseClassFeedbackResponse::create($input);
        Flash::success('Course Class Feedback Response Saved Successfully.');
        return redirect(route('courseClassFeedbackResponses.index'));
        
    }
  
    public function show($id)
    {
        $courseClassFeedbackResponse = CourseClassFeedbackResponse::find($id);

        if(empty($courseClassFeedbackResponse)){
            Flash::error('Course Class Feedback Response not Found');      
            return redirect(route('courseClassFeedbackResponses.index'));
        }
        return view('course_class_feedback_responses.show')->with('courseClassFeedbackResponse', $courseClassFeedbackResponse);
    }
  
    public function edit($id)
    {
        $courseClassFeedbackResponse = CourseClassFeedbackResponse::find($id);

        if(empty($courseClassFeedbackResponse)){
            Flash::error('Course Class Feedback Response not Found');
            return redirect(route('courseClassFeedbackResponses.index'));
        }
        return view('course_class_feedback_responses.edit')->with('courseClassFeedbackResponse', $courseClassFeedbackResponse);     
    }
  
    public function update(UpdateCourseClassFeedbackResponseRequest $request, $id)
    {
        $courseClassFeedbackResponse = CourseClassFeedbackResponse::find($id);

        if(empty($courseClassFeedbackResponse)){
            Flash::error('Course Class Feedback Response not Found');
            return redirect(route('courseClassFeedbackResponses.index'));
        }

        $courseClassFeedbackResponse->update($request->all());

        Flash::success('Course Class Feedback Response Updated Successfully');
        return redirect(route('courseClassFeedbackResponses.index'));
    }
 
    public function destroy($id)
    {
        $courseClassFeedbackResponse = CourseClassFeedbackResponse::find($id);

        if(empty($courseClassFeedbackResponse)){
            Flash::error('Course Class Feedback Response not Found');
            return redirect(route('courseClassFeedbackResponses.index'));
        }

        $courseClassFeedbackResponse->delete();

        Flash::success('Course Class Feedback Response Deleted Successfully');
        return redirect(route('courseClassFeedbackResponses.index'));  
    }
}
