@extends('layouts.app')

@section('title_postfix')
{{ ($courseClass) ?  $courseClass->code : '' }} :: {{ ($courseClass) ? $courseClass->name : '' }}
@stop
@section('page_title')
<div class="col-sm-6">
    <a class="btn btn-primary" style="margin-left:-25px" href="{{ url('/dashboard/class/'.$courseClass->id)}}">Go Back</a>
</div>
@stop
@section('content')

@include('flash::message')

@if($current_user->lecturer_id != null)
<div class="col-sm-12 panel panel-default card-view pa-20">
        <table class="table table-bordered table-hover table-responsive table-condensed">     
            <thead>
                <tr>
                    <th scope="col-sm-3" class="text-center" style="font-size: 90%">
                        Teaching Rating
                    </th>
                    <th scope="col" class="text-center" style="font-size:90%">
                        Clarification Rating
                    </th>
                    <th scope="col"  class="text-center" style="font-size:90%">
                        Assignments Rating
                    </th>
                    <th scope="col"  class="text-center" style="font-size:90%">
                        Examination Rating
                    </th>
                    <th scope="col"  class="text-center" style="font-size:90%">
                        Remarks
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($feedback_responses as $key => $x)
                    @if(($x->course_class_id == $courseClass->id) && ($x->course_class_feedback_id == $courseFeedback->id))
                        <tr class="text-center">   
                            <td class="text-center">
                                {{$x->teaching_rating_point}}
                            </td>
                            <td class="text-center">
                                {{$x->clarification_rating_point}}
                            </td>
                            <td class="text-center">
                                {{$x->assignments_rating_point}}
                            </td>
                            <td class="text-center">
                                {{$x->examination_rating_point}}
                            </td>
                            <td class="text-center">
                                {{$x->note}}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
         
     </table>
     <br>
     @if ($course_class_feedback_responses == 0)
       <p style="font-size:95%; text-align:center" class="muted text-danger">No Feedback Response Available.</p>
    @endif
</div>
@endif

@if($current_user->manager_id!= null)
<div class="col-sm-12 panel panel-default card-view pa-20">
<table class="table table-bordered table-hover table-responsive table-condensed">     
    <thead>
        <tr>
            <th scope="col-sm-3" class="text-center" style="font-size: 90%">
                Student Name
            </th>
            <th scope="col-sm-3" class="text-center" style="font-size: 90%">
                Teaching Rating
            </th>
            <th scope="col" class="text-center" style="font-size:90%">
                Clarification Rating
            </th>
            <th scope="col"  class="text-center" style="font-size:90%">
                Assignments Rating
            </th>
            <th scope="col"  class="text-center" style="font-size:90%">
                Examination Rating
            </th>
            <th scope="col"  class="text-center" style="font-size:90%">
                Remarks
            </th>
        </tr>
    </thead>
<tbody>
@foreach ($feedback_responses as $key => $x)
    @if(($x->course_class_id == $courseClass->id) && ($x->course_class_feedback_id == $courseFeedback->id))
        <tr class="text-center">   
                @foreach ($students as $key => $y)
                    @if ($y->id == $x->student_id)
                        <td class="text-center">
                            {{$y->last_name}} {{$y->first_name}} 
                        </td> 
                    @endif                         
                @endforeach    
            <td class="text-center">
                {{$x->teaching_rating_point}}
            </td>
            <td class="text-center">
                {{$x->clarification_rating_point}}
            </td>
            <td class="text-center">
                {{$x->assignments_rating_point}}
            </td>
            <td class="text-center">
                {{$x->examination_rating_point}}
            </td>
            <td class="text-center">
                {{$x->note}}
            </td>
        </tr>
    @endif 
@endforeach
        </tbody>
   </table>
   <br>
    @if ($course_class_feedback_responses == 0)
      <p style="font-size:95%; text-align:center" class="muted text-danger">No Feedback Response Available.</p>
    @endif
</div> 
@endif
      
@endsection
@section('js-135')
<script type="text/javascript">
</script>
@endsection