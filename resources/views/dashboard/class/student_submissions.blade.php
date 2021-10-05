
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
                    <th>Comment</th>
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
                        <td style="width:20%">{{ $item->student->matriculation_number }}</td>

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
                            @endphp
                            {!! Form::number("txt_score_{$idx}", $score, ['id'=>"txt_score_{$idx}",'placeholder'=>"",'class'=>"form-control score-input scores text-right {$selector}-{$item->student->matriculation_number}",'data-val-id'=>"{$class_material->id}",'data-val-lbl'=>"",'data-val-mp'=>"{$class_material->grade_max_points}",'data-val-matric'=>"{$item->student->matriculation_number}"]) !!}
                        </td>
                        <td>
                            @if (isset($assignment_submissions[$item->student->id]))
                            <a href="" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#mdl-comment-modal_{{ $item->student->id }}">
                                <i class=" fa fa-comment"></i>
                            </a>
                            @else
                            <span class="text-danger text-center" style="font-size:85%">No Submission</span>
                            @endif
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

    {{-- Submissions comment modal --}}
    @foreach ($submissions as $submission)
    <div class="modal fade" id="mdl-comment-modal_{{ $submission->student->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 id="lbl-faq-modal-title" class="modal-title">Grading comments</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" id="frm-comment-modal" role="form" method="POST" action="{{ route('dashboard.lecturer.save-comment') }}">
                        <div class="row">
                            <div class="ma-10">
                                <input type="hidden" name="submission_id" value="{{ $submission->id }}">
                                {{-- <div class="spinner2">
                                    <div class="loader" id="loader-1"></div>
                                </div> --}}
                                <div id="div-name" class="form-group">
                                    <label class="control-label mb-10 col-sm-2" for="name">Student Name</label>
                                    <div class="col-sm-10">
                                        {!! Form::text('name', $submission->student->first_name.' '.$item->student->last_name, ['class' => 'form-control', 'disabled'=>true]) !!}
                                    </div>
                                </div>
                                <div id="div-matric" class="form-group">
                                    <label class="control-label mb-10 col-sm-2" for="matric">Matric Number</label>
                                    <div class="col-sm-10">
                                        {!! Form::text('matric', $submission->student->matriculation_number, ['class' => 'form-control', 'disabled'=>true]) !!}
                                    </div>
                                </div>
                                @php
                                    $score = null;
                                    if (isset($grades[$submission->student->id])){
                                        $score = $grades[$submission->student->id];
                                    }
                                @endphp
                                <div id="div-score" class="form-group">
                                    <label class="control-label mb-10 col-sm-2" for="score">Score</label>
                                    <div class="col-sm-10">
                                        {!! Form::number('score', $score, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div id="div-comment" class="form-group">
                                    <label class="control-label mb-10 col-sm-2" for="comment">Comment</label>
                                    <div class="col-sm-10">
                                        {!! Form::textarea('comment', $submission->comment, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <hr class="light-grey-hr mb-10" />
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-comment-modal" value="add">Save</button>
                </div>

            </div>
        </div>
    </div>
    @endforeach
    
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
                    swal("Done!", "Grades saved successfully with some issues.", "success");
                }else{
                    swal("Done!", "Grades saved successfully", "success");
                }

                window.setTimeout( function(){
                    $('.spinner1').hide();
                },100);
            },
        });

    });

});

$(document).on('click', '#btn-save-mdl-comment-modal', function(e) {
    e.preventDefault();
    $('.spinner2').show();
    let formData = new FormData();
    formData.append('_token', $('input[name="_token"]').val());
    formData.append('_method', "POST");
    formData.append('comment', $('textarea[name="comment"]').val());
    formData.append('score', $('input[name="score"]').val());
    formData.append('submission_id', $('input[name="submission_id"]').val());
    let endPointUrl = $('#frm-comment-modal').attr('action');
    $.ajax({
        url:endPointUrl,
        type: "POST",
        data: formData, 
        cache: false,
        processData:false, 
        contentType: false,
        dataType: 'json',
        success: function(result){
            $('.spinner2').hide();
            swal("Done!", "Grades saved successfully with some issues.", "success");
            window.location.reload();
        },
    });
})
</script>
@endsection