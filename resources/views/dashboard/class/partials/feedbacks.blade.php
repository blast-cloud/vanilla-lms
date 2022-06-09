<!--   Students Dashboard     -->
@if ($current_user->student_id != null)
    @foreach($feedback_requests as $x)
      <div class="row">
        @if ($x->course_class_id == $courseClass->id)
         <hr class="light-grey-hr mb-10 mt-0" style="width:96%"/>
          <div class="col-md-6">
            <dl>
                <dt class="mb-0">
                    <span class="text-primary" style="font-size:100%"><i class="fa fa-bell" aria-hidden="true"></i> New Feedback Request For {{$courseClass->code}} Class</span><br>
                    Start Date for Submission: <span id="spn_ass_{{$x->id}}_date">{{ date('d-m-Y', strtotime($x->start_date)) }} <br>
                    Due Date for Submission: <span id="spn_ass_{{$x->id}}_date">{{ date('d-m-Y', strtotime($x->end_date)) }}</span><br>
                    Remarks: <span>{{$x->note}}</span>
                    <br> 
                </dt>
                <dd class="mb-0" style="font-size:85%;">
                    @php
                    $responses = $x->courseFeedbackResponse()
                                   ->where('course_class_feedback_id', $x->id)
                                   ->where('course_class_id', $x->course_class_id)
                                   ->where('student_id', $current_user->student_id)
                                   ->count();
                    if($responses == 0){
                        $responses = "You have not responded to this request.";
                    }elseif($responses == 1){
                        $responses = "You have responded to this request.";
                    }else{
                        $responses = "You can't respond more than once.";
                    }
                    @endphp
            <i class="text-info fa fa-bell" aria-hidden="true"></i><strong><span class="text-info">{{ $responses }}</span></strong>             
            </dd>
           </dl>       
       </div>
<div class="col-md-6" style="text-align:right">
    @php
        $response = $x->courseFeedbackResponse()
                      ->where('course_class_feedback_id', $x->id)
                      ->where('course_class_id', $x->course_class_id)
                      ->where('student_id', $current_user->student_id)
                      ->count();
    @endphp
    @if((time() >= strtotime($x->start_date)) && (time() <= strtotime($x->end_date) + strtotime('+1 day'))  && $response == 0)
    <button href="#" id="btn-show-feedback-response-modal" class="btn btn-xs btn-primary btn-show-feedback-response-modal"
    data-val-feedback-request-id="{{$x->id}}" data-val-student-id="{{$current_user->student_id}}">
        <i class="fa fa-upload" style=""></i>Respond
    </button> 
    @endif
</div> 
 @endif   
</div>
@endforeach
<hr class="light-grey-hr mb-10 mt-0"/>
@if ($course_class_feedback_requests == 0)
    <p style="font-size:95%;" class="muted">No Feedback Requests Available.</p>
@endif

<!--   Managers Dashboard     -->
@elseif($current_user->manager_id != null)
<button href="#" id="btn-show-feedback-request-modal" class="btn btn-xs btn-primary btn-show-feedback-request-modal"
data-val-creator-id="{{$current_user->id}}" data-val-department-id="{{$current_user->department_id}}">
    <i class="fa fa-upload" style=""></i> Request Feedback
</button>
@foreach($feedback_requests as $x)
<div class="row">
  @if($x->course_class_id == $courseClass->id)
   <hr class="light-grey-hr mb-10 mt-0" style="width:96%"/>
      <div class="col-md-6">
          <dl>
              <dt class="mb-0">
                  <span class="text-primary" style="font-size:100%"><i class="fa fa-bell" aria-hidden="true"></i> Feedback Request Sent For {{$courseClass->code}} Class</span><br>
                  Start Date for Submission: <span id="spn_start_{{$x->id}}_date">{{ date('d-m-Y', strtotime($x->start_date)) }}</span><br>
                  Due Date for Submission: <span id="spn_due_{{$x->id}}_date">{{ date('d-m-Y', strtotime($x->end_date)) }}</span><br>
                  Remarks: <span id="spn_{{$x->id}}_remarks">{{$x->note}}</span>
                  <br>
              </dt>
            <dd class="mb-0" style="font-size:85%;">
                <a class="text-info btn-edit-feedback-request-modal" id="btn-edit-feedback-request-modal" href="#" alt="Edit Feedback Request"  data-val-edit-feedback="{{$x->id}}">
                        <i class="fa fa-pencil" style=""></i>&nbsp;Edit
                </a> &nbsp;&nbsp;
                <a class="text-info btn-delete-feedback-request-modal" id="btn-delete-feedback-request-modal" href="#"  alt="Delete Feedback Request" data-val-delete-feedback="{{$x->id}}">
                    <i class="fa fa-trash" style=""></i>&nbsp;Delete
                </a> &nbsp;&nbsp;
        @php
            $responses = $x->courseFeedbackResponse()
                           ->where('course_class_feedback_id', $x->id)
                           ->where('course_class_id', $x->course_class_id)
                           ->count();
            if($responses == 0){
                $responses = " No response from students.";
            }elseif($responses == 1){
                $responses = $responses."  response from a student.";
            }else{
                $responses = $responses."  responses from students.";
            }
        @endphp
       <i class="text-info fa fa-bell" aria-hidden="true"></i>&nbsp;<strong><span class="text-info">{{ $responses }}</span></strong> &nbsp;&nbsp;
     </dd>       
</dl>       
</div> 
<div class="col-md-6" style="text-align:right">
    <a href="{{ route('responded-feedback-list', [$x->course_class_id, $x->id]) }}" class="btn btn-xs btn-info btn-feedback-responses" data-val="{{$x->id}}">
        <i class="fa fa-eye" style=""></i> View Responses
    </a>
</div> 
@endif   
</div>
@endforeach
<hr class="light-grey-hr mb-10 mt-0"/>
    @if ($course_class_feedback_requests == 0)
        <p style="font-size:95%;" class="muted">No Feedback Requests Available.</p>
    @endif
    
<!--   Lecturers Dashboard     -->
@elseif($current_user->lecturer_id != null)
@foreach($feedback_requests as $x)
<div class="row">
  @if ($x->course_class_id == $courseClass->id)
    <hr class="light-grey-hr mb-10 mt-0" style="width:96%"/>
      <div class="col-md-6">
          <dl>
              <dt class="mb-0">
                <span class="text-primary" style="font-size:85%"><i class="fa fa-bell" aria-hidden="true"></i> A Feedback was Requested for {{ $courseClass->code }} Class on {{ date('d-m-Y', strtotime($x->created_at))}}.</span><br><br>
                <span class="text-primary" style="font-size:85%"><i class="fa fa-bell" aria-hidden="true"></i> Response from Students will be available after {{ date('d-m-Y', strtotime($x->end_date))}}.</span><br><br>
              </dt>
         </dl>           
</div> 
<div class="col-md-6" style="text-align:right">   
    <!-- if(time() >= (strtotime($x->end_date) + strtotime('+1 day'))) -->
        <a href="{{ route('responded-feedback-list', [$x->course_class_id, $x->id]) }}" class="btn btn-xs btn-info btn-feedback-responses" data-val="{{$x->id}}">
            <i class="fa fa-eye" style=""></i> View Responses
        </a> 
   <!--  endif -->
</div> 
@endif   
</div>
@endforeach
<hr class="light-grey-hr mb-10 mt-0"/>
@if($course_class_feedback_requests == 0)
    <p style="font-size:95%;" class="muted">No Feedback Requests Available.</p>
@endif
@endif
@section('js-131')
<script type="text/javascript">
</script>
@endsection