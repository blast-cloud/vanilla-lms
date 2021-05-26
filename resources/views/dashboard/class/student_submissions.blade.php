
@extends('layouts.app')


@section('title_postfix')
{{ ($courseClass) ?  $courseClass->code : '' }} :: {{ ($courseClass) ? $courseClass->name : '' }}
@stop

@section('page_title')
{{ ($courseClass) ? $courseClass->code : '' }} :: {{ ($courseClass) ? $courseClass->name : '' }}<br/>
<small class="muted text-primary"><i>Taught by {{ ($courseClass && $courseClass->lecturer) ? $courseClass->lecturer->job_title : '' }} {{ ($courseClass && $courseClass->lecturer) ? $courseClass->lecturer->first_name : '' }} {{ ($courseClass && $courseClass->lecturer) ? $courseClass->lecturer->last_name : '' }}</i></small>
<br/>
@stop



@section('content')
    
    @include('flash::message')


    <div class="col-sm-9 panel panel-default card-view">

       @if (isset($assignment_submissions) && count($assignment_submissions)> 0)
        
       <table class="table table-bordered table-striped table-responsive">

        <thead>
            <tr>
                <th>S/N</th>
                <th>Name</td>
                <th>Matric Number</th>
                <th style="text-align:center">File</th>
                <th style="text-align:center">Score</th>
            </tr>
        </thead>

        <tbody>

                @php
                    $x = 0;
                @endphp

                @foreach ($assignment_submissions as $item)

                  {{--   @php
                        $grade = ($item->grade_id != null) ? "<a data-val-submission-id=".$item->id." data-val-course-class-id=".$item->course_class_id." data-val-student-id=".$item->student_id." data-val-class-material-id=".$item->class_material_id."  data-val-grade-id='0' class='btn btn-xs btn-danger btn-assignment-grade' href='#' >Not Yet Graded </a>"; : "<a data-val-submission-id=".$item->id." data-val-course-class-id=".$item->course_class_id." data-val-student-id=".$item->student_id." data-val-class-material-id=".$item->class_material_id."  data-val-grade-id='0' class='btn btn-xs btn-danger btn-assignment-grade' href='#' >Not Yet Graded </a>";
                    @endphp --}}
                <tr>
                    <td>{{ ++$x }}</td>
                    <td style="width:30%">{{ $item->student->last_name }}  {{ $item->student->first_name }}</td>
                    <td style="width:30%">{{ $item->student->matriculation_number }}</td>
                    <td style="width:10%">
                        <a href="{{ asset($item->upload_file_path) }}"  class="btn btn-xs btn-info" download>
                                <i class="fa fa-download" style=""></i> Download
                            </a>
                    </td>
                    <td style="text-align:center">
                        {{ ($item->grade_id != null) ? $item->grade->score.'/'.$item->classMaterial->grade_max_points: '0/'.$item->classMaterial->grade_max_points }} <br> 
                        <a data-val-submission-id="{{ $item->id }}" 
                            data-val-course-class-id="{{ $item->course_class_id }}" 
                            data-val-student-id="{{ $item->student_id }}" 
                            data-val-class-material-id="{{ $item->class_material_id }}" 
                             data-val-grade-id='{{ ($item->grade_id != null) ? $item->grade_id : "0" }}' 
                             data-val-grade-title='{{ ($item->grade_id != null) ? $item->grade->grade_title : "" }}' 
                             data-val-score='{{ ($item->grade_id != null) ? $item->grade->score : "" }}' 
                             data-val-grade-letter='{{ ($item->grade_id != null) ? $item->grade->grade_letter : "" }}' 
                             class="btn btn-xs  btn-assignment-grade {{ ($item->grade_id != null) ? "btn-primary " : "btn-danger" }}"  
                            
                              href='#'
                            > {{ ($item->grade_id != null) ? "Edit Score" : "Not Yet Graded" }} </a>
                    </td>
                </tr>
                @endforeach

        </tbody>
           
        </table>

           
       @else
           
       @endif

    </div>
    <div class="col-sm-3">

        @include("dashboard.partials.side-panel")
    </div>

    @include("dashboard.class.modals.grade-assignment")
    
@endsection

