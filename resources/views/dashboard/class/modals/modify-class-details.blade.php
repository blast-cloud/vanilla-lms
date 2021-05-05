

<div class="modal fade" id="modify-class-detail-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-class-detail-title" class="modal-title">Class Details</h4>
            </div>

            <div class="modal-body">
                <div id="modify-class-detail-error-div" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="form-modify-class-detail" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-11 ma-10">
                            @csrf
                            
                            <div class="form-wrap">
                                
                                <div class="col-sm-12">

                                    
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-2" for="txt_class_email">Class Email</label>
                                        <div class="col-sm-4">
                                            {!! Form::text('txt_class_email', null, ['id'=>'txt_class_email','class' => 'form-control','placeholder'=>'class@school.edu.ng']) !!}
                                        </div>
                                        <label class="control-label mb-10 col-sm-2" for="txt_class_phone">Phone#</label>
                                        <div class="col-sm-4">
                                            {!! Form::text('txt_class_phone', null, ['id'=>'txt_class_phone','class' => 'form-control','placeholder'=>'07063321457']) !!}
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-2" for="txt_class_next_lecture_date">Next Lecture</label>
                                        <div class="col-sm-4">
                                            {!! Form::text('txt_class_next_lecture_date', null, ['class' => 'form-control','id'=>'txt_class_next_lecture_date','placeholder'=>'Lecture Date']) !!}
                                        </div>
                                        <label class="control-label mb-10 col-sm-2" for="txt_class_next_exam_date">Next Exam</label>
                                        <div class="col-sm-4">
                                            {!! Form::text('txt_class_next_exam_date', null, ['class' => 'form-control','id'=>'txt_class_next_exam_date','placeholder'=>'Exam Date']) !!}
                                        </div>
                                    </div>
<!-- 
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-2" for="txt_class_lecture_period">Lecture <br/>Periods</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="col-sm-4">Monday</div>
                                                    <div class="col-sm-8">{!! Form::text('txt_class_monday', null, ['class' => 'form-control']) !!}</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="col-sm-4">Tuesday</div>
                                                    <div class="col-sm-8">{!! Form::text('txt_class_monday', null, ['class' => 'form-control']) !!}</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="col-sm-4">Wednesday</div>
                                                    <div class="col-sm-8">{!! Form::text('txt_class_monday', null, ['class' => 'form-control']) !!}</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="col-sm-4">Thursday</div>
                                                    <div class="col-sm-8">{!! Form::text('txt_class_monday', null, ['class' => 'form-control']) !!}</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="col-sm-4">Friday</div>
                                                    <div class="col-sm-8">{!! Form::text('txt_class_monday', null, ['class' => 'form-control']) !!}</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="col-sm-4">Saturday</div>
                                                    <div class="col-sm-8">{!! Form::text('txt_class_monday', null, ['class' => 'form-control']) !!}</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="col-sm-4">Sunday</div>
                                                    <div class="col-sm-8">{!! Form::text('txt_class_monday', null, ['class' => 'form-control']) !!}</div>
                                                </div>
                                                <div class="col-sm-6">
                                                </div>
                                            </div>


                                        </div>
                                    </div>
 -->

                                </div>
                                
                            </div>                            


                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-modify-class-detail" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-131')
<script type="text/javascript">
$(document).ready(function() {

    $('#txt_class_next_exam_date').datetimepicker({
        //format: 'YYYY-MM-DD HH:mm:ss',
        format: 'YYYY-MM-DD',
        useCurrent: true,
        sideBySide: true
    });

    $('#txt_class_next_lecture_date').datetimepicker({
        //format: 'YYYY-MM-DD HH:mm:ss',
        format: 'YYYY-MM-DD',
        useCurrent: true,
        sideBySide: true
    });


    //Show Modal
    $('#btn-show-modify-class-detail-modal').click(function(){
        $('#modify-class-detail-error-div').hide();
        $('#modify-class-detail-modal').modal('show');

        $('#txt_class_email').val($('#spn_class_email').html());
        $('#txt_class_phone').val($('#spn_class_phone').html());
        $('#txt_class_next_lecture_date').val($('#spn_next_lecture_date').html());
        $('#txt_class_next_exam_date').val($('#spn_next_exam_date').html());
    });

    //Save lecturer
    $('#btn-modify-class-detail').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', 'PUT');
        formData.append('id', {{$courseClass->id}});
        formData.append('email_address', $('#txt_class_email').val());
        formData.append('telephone', $('#txt_class_phone').val());
        formData.append('next_lecture_date', $('#txt_class_next_lecture_date').val());
        formData.append('next_exam_date', $('#txt_class_next_exam_date').val());

        let artifact_url = "{{ route('courseClasses.update', $courseClass->id) }}";
        $.ajax({
            url:artifact_url,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(result){
                if(result.errors){
                    $('#modify-class-detail-error-div').html('');
                    $('#modify-class-detail-error-div').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#modify-class-detail-error-div').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#modify-class-detail-error-div').hide();
                    window.setTimeout( function(){
                        window.alert("Class details saved successfully.");
                        $('#modify-class-detail-modal').modal('hide');
                        location.reload(true);
                    }, 500);
                }
            },
        }); 
    });

});
</script>
@endsection
