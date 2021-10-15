<a id="btn-export-student-scores" target="_blank" style="opacity:0.8;font-size:85%" href="{{ route('dashboard.lecturer.grade-export',$courseClass->id) }}" class="text-info pull-right mb-5">
    <i class="fa fa-download" style=""></i>&nbsp;Export
</a>
<ol id="lst_grade_messages" class="ma-20" style="font-size:90%"></ol>
@if (count($enrollments)>0)
    <div class="grade-container" style="width: 100%; overflow-x: auto;">
    <table class="table table-bordered table-striped" style="border-collapse: collapse; overflow-x: scroll;">
        <div class="spinner1">
            <div class="loader" id="loader-1"></div>
        </div>
        <thead>
            <tr>
                <td>
                    @if ($current_user->lecturer_id!=null)
                    <a id="btn-save-student-scores" href="#" class="btn btn-xs btn-primary vertical-align-middle">
                        <i class="fa fa-save" style=""></i>&nbsp;Save
                    </a>
                    @endif
                </td>
                <td class="text-center" style="font-size:80%">
                    Final Grade
                </td>
                @foreach($gradeManager->get_assignment_list() as $idx=>$item)
                    @if ($item->course_class_id == $courseClass->id )
                        <td class="text-center" style="font-size:80%">
                            Assignment {{ $item->assignment_number }} <!-- - {{ $item->title }} --> <br/>
                            <span class="text-info">{{ $item->grade_max_points }}pts ({{ $item->grade_contribution_pct }}%)</span> <br/>
                            <a class="text-info btn-edit-modify-assignment-modal" href="#" alt="Edit Assignment" style="opacity:0.5;font-size:85%" data-val="{{$item->id}}">
                                <i class="fa fa-pencil" style=""></i>&nbsp;Edit
                            </a>
                        </td>   
                    @endif
                @endforeach

                @foreach($gradeManager->get_examination_list() as $idx=>$item)
                    @if ($item->course_class_id == $courseClass->id )
                        <td class="text-center" style="font-size:80%">
                            Exam {{ $item->examination_number }} <!-- - {{ $item->title }} --> <br/>
                            <span class="text-info">{{ $item->grade_max_points }}pts ({{ $item->grade_contribution_pct }}%)</span>
                            <br/>
                            <a class="text-info btn-edit-modify-examination-modal" href="#" alt="Edit examination" style="opacity:0.5;font-size:85%" data-val="{{$item->id}}">
                                <i class="fa fa-pencil" style=""></i>Edit
                            </a>
                        </td>
                    @endif
                @endforeach
            </tr>
        </thead>
        @foreach($gradeManager->get_map() as $idx=>$grade_item)
        <tr>
            <td>
                {{$grade_item['name']}} - {{$grade_item['matric_num']}}
                <span id="grade_class_participation_{{$grade_item['matric_num']}}" class="small grade_class_participation"></span>
            </td>
            <td>
                @php
                    $score = null;
                    $grade = isset($grade_item['final-grade']) ? $grade_item['final-grade'] : null;
                    if ($grade != null){ $score = $grade->score; }
                @endphp
                {!! Form::number("txt_score_{$idx}", $score, ['id'=>"txt_score_{$idx}",'placeholder'=>"",'class'=>"form-control final-scores text-right fs-{$grade_item['matric_num']}",'data-val-id'=>'final','data-val-matric'=>"{$grade_item['matric_num']}","disabled"=>'',"readonly"=>'']) !!}
            </td>

            @foreach($gradeManager->get_assignment_list() as $idx=>$item)
                @if ($item->course_class_id == $courseClass->id )
                    <td>
                        @php
                        $score = $grade_item['assignments'][$idx]['score'];
                        $max = $grade_item['assignments'][$idx]['max_points'];
                        $label = $grade_item['assignments'][$idx]['label'];
                        @endphp
                        {!! Form::number("txt_{$idx}", $score, ['id'=>"txt_{$idx}", 'placeholder'=>"",'class' => "score-input form-control assignment-scores text-right as-{$item->id}-{$grade_item['matric_num']}",'data-val-lbl'=>"{$label}",'data-val-mp'=>"{$max}",'data-val-id'=>"{$item->id}",'data-val-matric'=>"{$grade_item['matric_num']}"]) !!}
                    </td>
                @endif
            @endforeach

            @foreach($gradeManager->get_examination_list() as $idx=>$item)
                @if ($item->course_class_id == $courseClass->id )
                    <td>
                        @php
                        $score = $grade_item['examinations'][$idx]['score'];
                        $max = $grade_item['examinations'][$idx]['max_points'];
                        $label = $grade_item['examinations'][$idx]['label'];
                        @endphp
                        {!! Form::number("txt_{$idx}", $score, ['id'=>"txt_{$idx}", 'placeholder'=>"",'class' => "score-input form-control exam-scores text-right es-{$item->id}-{$grade_item['matric_num']}",'data-val-lbl'=>"{$label}",'data-val-mp'=>"{$max}",'data-val-id'=>"{$item->id}",'data-val-matric'=>"{$grade_item['matric_num']}"]) !!}
                    </td>
                @endif
            @endforeach
        </tr>
        @endforeach
    </table>
    </div>
@else
No Enrolled Students
@endif




@section('js-137')
<script type="text/javascript">
$(document).ready(function() {
    $('.spinner1').hide();

    //Load the class participation in grading window
    $(".participation_score").each(function() {
        let matric = $(this).attr("data-participation-matric");
        let score = $(this).attr("data-participation-score");

        if (score===null || score==="" ){
            score = "No Acticity";
        }

        $("#grade_class_participation_"+matric).html("<br/> Participation : <span class='text-primary'>"+score+"</span>");
    });

    //Show Modal for Edit
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

        //Get final scores
        // $(".final-scores").each(function() {
        //     grade_list.push({
        //         'type':"final",
        //         'score':$(this).val(),
        //         'student_matric':$(this).attr("data-val-matric")
        //     });
        // });

        //Get assignment scores
        $(".assignment-scores").each(function() {
            grade_list.push({
                'type':"assignment",
                'score':$(this).val(),
                'student_matric':$(this).attr("data-val-matric"),
                'assignment_id':$(this).attr("data-val-id"),
                'max_mp':$(this).attr("data-val-mp"),
                'label':$(this).attr("data-val-lbl"),
            });
        });

        //Get exam scores
        $(".exam-scores").each(function() {
            grade_list.push({
                'type':"exam",
                'score':$(this).val(),
                'student_matric':$(this).attr("data-val-matric"),
                'exam_id':$(this).attr("data-val-id"),
                'max_mp':$(this).attr("data-val-mp"),
                'label':$(this).attr("data-val-lbl"),
            });
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
                    // swal("Done!", "Grades saved successfully with some issues.", "success");
                    $.each(result.message, function(key, value){
                        $('#lst_grade_messages').append('<li class="text-danger">'+value+'</li>');
                        $('.'+key).css('border-color','red');
                    });
                }else{
                    swal("Done!", "Grades saved successfully.", "success");
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
