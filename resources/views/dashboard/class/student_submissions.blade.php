
@extends('layouts.app')


@section('title_postfix')
{{ ($courseClass) ?  $courseClass->code : '' }} :: {{ ($courseClass) ? $courseClass->name : '' }}
@stop

@section('page_title')
{{ ($courseClass) ? $courseClass->code : '' }} :: {{ ($courseClass) ? $courseClass->name : '' }}<br/>
<small class="muted text-primary"><i>Taught by {{ ($courseClass && $courseClass->lecturer) ? $courseClass->lecturer->job_title : '' }} {{ ($courseClass && $courseClass->lecturer) ? $courseClass->lecturer->first_name : '' }} {{ ($courseClass && $courseClass->lecturer) ? $courseClass->lecturer->last_name : '' }}</i></small>
<br/>
<br/>
@stop



@section('content')


    @include('flash::message')


    <div class="col-sm-9 panel panel-default card-view">

        @if ($class_material->type=="class-assignments" || $class_material->type=="class-examinations")
            @if ($current_user->lecturer_id!=null)
            <a id="btn-save-student-scores" href="#" class="btn btn-xs btn-primary vertical-align-middle pull-right">
                <i class="fa fa-save" style=""></i>&nbsp;Save
            </a>
            @endif
        @endif

        <dl class="ma-10">
            <dt class="mb-0">
                @if ($class_material->type=="class-assignments")
                Assignment #<span id="spn_ass_{{$class_material->id}}_num">{{$class_material->assignment_number}}</span> - Due on <span id="spn_ass_{{$class_material->id}}_date">{{ date('Y-m-d', strtotime($class_material->due_date)) }} </span> - <span id="spn_ass_{{$class_material->id}}_title">{{$class_material->title}}</span>
                @elseif ($class_material->type=="class-examinations")
                Examination #<span id="spn_exam_{{$class_material->id}}_num">{{$class_material->examination_number}}</span> - Exam scheduled for <span id="spn_exam_{{$class_material->id}}_date">{{ date('Y-m-d', strtotime($class_material->due_date)) }} </span> - <span id="spn_exam_{{$class_material->id}}_title">{{$class_material->title}}</span>
                @endif
                <span class="text-danger" style="font-size:80%"><br/>
                Posted on {{ $class_material->created_at->format('d-M-Y') }} &nbsp;&nbsp;|&nbsp;&nbsp;  Points <span id="spn_ass_{{$class_material->id}}_max_points">{{ $class_material->grade_max_points }}</span>, contributes <span id="spn_ass_{{$class_material->id}}_contrib">{{ $class_material->grade_contribution_pct }}</span>% to final score.
                </span> <br>
            </dt>
            <dd>
                <a href="{{ route('dashboard.class',$courseClass->id) }}" style="opacity:0.5;font-size:85%" class="text-info"><< Back to Class Details</a><br/>
            </dd>
        </dl>



       @if (isset($enrollments) && count($enrollments)> 0)
       
        <ol id="lst_grade_messages" class="ma-20" style="font-size:90%"></ol>

        <table class="table table-bordered table-striped table-responsive mb-10">

            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Student Name</td>
                    <th>Matric Number</th>
                    @if ($class_material->type=="class-assignments")
                    <th style="text-align:center">File</th>
                    @endif
                    <th style="text-align:center">Score</th>
                </tr>
            </thead>

            <tbody>

                    @php
                        $x = 0;

                        $selector = "";
                        if ($class_material->type=="class-assignments"){        $selector="as-{$class_material->id}";  }
                        else if ($class_material->type=="class-examinations"){  $selector="es-{$class_material->id}";  }

                    @endphp

                    @foreach ($enrollments as $idx=>$item)
                    <tr>
                        <td>{{ ++$x }}</td>
                        <td style="width:40%">{{ $item->student->last_name }}  {{ $item->student->first_name }}</td>
                        <td style="width:30%">{{ $item->student->matriculation_number }}</td>

                        @if ($class_material->type=="class-assignments")
                        <td style="width:10%" class="text-center">
                            @if (isset($assignment_submissions[$item->student->id]))
                            <a href="{{ asset($assignment_submissions[$item->student->id]) }}"  class="btn btn-xs btn-info" download>
                                <i class="fa fa-download" style=""></i>
                            </a>
                            @else
                            <span class="text-danger text-center" style="font-size:85%">No Submission</span>
                            @endif
                        </td>
                        @endif
                        
                        <td style="width:200px">
                            @php
                                $score = null;
                                if (isset($grades[$item->student->id])){
                                    $score = $grades[$item->student->id];
                                }

                                $id_code = sha1($item->student->matriculation_number);
                                
                            @endphp
                            {!! Form::number("txt_score_{$idx}", $score, ['id'=>"txt_score_{$idx}",'placeholder'=>"",'class'=>"form-control score-input scores text-right {$selector}-{$id_code}",'data-val-id'=>"{$class_material->id}",'data-val-lbl'=>"",'data-val-mp'=>"{$class_material->grade_max_points}",'data-val-matric'=>"{$item->student->matriculation_number}"]) !!}
                        </td>
                    </tr>
                    @endforeach

            </tbody>
            
        </table>

       @else
            &nbsp;&nbsp;No Enrollements for this class
           <br/>
           <br/>
       @endif

    </div>
    <div class="col-sm-3">
        @include("dashboard.partials.side-panel")
    </div>
    
@endsection


@section('js-135')
<script type="text/javascript">
$(document).ready(function() {

    $(document).on('click', "#btn-save-student-scores", function(e) {

        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                
        let actionType = "POST";
        let endPointUrl = "{{ route('dashboard.lecturer.grade-update',$courseClass->id) }}";

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);

        $('.spinner1').show();

        var grade_list = [];

        //Get scores
        $(".scores").each(function() {
            if ($(this).val()!=null){
                grade_list.push({
                    'score':$(this).val(),
                    'student_matric':$(this).attr("data-val-matric"),
                    'max_mp':$(this).attr("data-val-mp"),
                    'label':$(this).attr("data-val-lbl"),
                    @if ($class_material != null)
                        @if ($class_material->type="class-assignments")
                            'type':"assignment",
                            'assignment_id':$(this).attr("data-val-id"),
                        @elseif ($class_material->type="class-examinations")
                            'type':"exam",
                            'exam_id':$(this).attr("data-val-id"),
                        @endif
                    @endif
                });
            }
        });

        formData.append('grade_list', JSON.stringify(grade_list));

        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData, 
            cache: false,
            processData:false, 
            contentType: false,
            dataType: 'json',
            success: function(result){

                $('#lst_grade_messages').empty();
                $('.score-input').css('border-color','#ccc');

                if(result.data){
                    $.each(result.data, function(key, value){ 
                        $('.'+key).val(value); 
                    });
                }

                if(result.message && Object.keys(result.message).length>0){

                    $.each(result.message, function(key, value){
                        $('#lst_grade_messages').append('<li class="text-danger">'+value+'</li>');
                        $('.'+key).css('border-color','red');
                    });

                    window.alert("Grades saved successfully with some issues.");

                }else{
                    window.alert("Grades saved successfully.");
                }

                window.setTimeout( function(){
                    $('.spinner1').hide();
                },100);
            },
        });

    });

});
</script>
@endsection