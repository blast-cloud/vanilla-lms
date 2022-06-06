<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Http\Requests;
use App\Http\Requests\CreateCourseClassFeedbackRequest;
use App\Http\Requests\UpdateCourseClassFeedbackRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\CourseClassFeedback;

class CourseClassFeedbackController extends AppBaseController
{

    public function store(CreateCourseClassFeedbackRequest $request)
    {
        $current_user = Auth()->user();
        $creator_user_id = $current_user->id;
        $department_id = $current_user->department_id;
        $input = array_merge($request->all(), ['creator_user_id'=>$creator_user_id], ['department_id' =>$department_id]);

        $courseClassFeedback = CourseClassFeedback::create($input);

        Flash::success('Course Class Feedback Saved Successfully.');     
        return redirect(route('courseClassFeedbacks.index'));       
    }
   
    public function show($id)
    {
        $courseClassFeedback = CourseClassFeedback::find($id);

        if(empty($courseClassFeedback)){
            Flash::error('Course Class Feedback not Found');    
            return redirect(route('courseClassFeedbacks.index'));
        }
        return view('course_class_feedbacks.show')->with('courseClassFeedback', $courseClassFeedback);     
    }

    public function edit($id)
    {
        $courseClassFeedback = CourseClassFeedback::find($id);

        if(empty($courseClassFeedback)){
            Flash::error('Course Class Feedback not Found');
            return redirect(route('courseClassFeedbacks.index'));
        }
        return view('course_class_feedbacks.edit')->with('courseClassFeedback', $courseClassFeedback);     
    }
  
    public function update(UpdateCourseClassFeedbackRequest $request, $id)
    {
        $courseClassFeedback = CourseClassFeedback::find($id);

        if(empty($courseClassFeedback)){
            Flash::error('Course Class Feedback not Found');
            return redirect(route('courseClassFeedbacks.index'));
        }

        $courseClassFeedback->update($request->all());

        Flash::success('Course Class Feedback Updated Successfully');
        return redirect(route('courseClassFeedbacks.index'));    
    }
  
    public function destroy($id)
    {
        $courseClassFeedback = CourseClassFeedback::find($id);

        if(empty($courseClassFeedback)){
            Flash::error('Course Class Feedback not Found');
            return redirect(route('courseClassFeedbacks.index'));
        }

        $courseClassFeedback->delete();

        Flash::success('Course Class Feedback Deleted Successfully');
        return redirect(route('courseClassFeedbacks.index'));       
    }
}
