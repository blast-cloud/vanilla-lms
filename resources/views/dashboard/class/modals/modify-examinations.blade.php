

<div class="modal fade" id="modify-examination-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-examination-title" class="modal-title">examinations</h4>
            </div>

            <div class="modal-body">
                <div id="modify-examination-error-div" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="form-modify-examination" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input id="txt_examination_id" type="hidden" value="0" />
                            <div class="form-wrap">
                                
                                <div class="col-sm-12">

                                    <!-- examination Number Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_examination_number">examination Number</label>
                                        <div class="col-sm-2">
                                            {!! Form::number('txt_examination_number', null, ['id'=>'txt_examination_number','min' => '0', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>


                                    <!-- Title Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_examination_title">Examination Title</label>
                                        <div class="col-sm-7">
                                            {!! Form::text('txt_examination_title', null, ['id'=>'txt_examination_title', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <!-- Description Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_examination_description">Description</label>
                                        <div class="col-sm-7">
                                            {!! Form::textarea('txt_examination_description', null, ['id'=>'txt_examination_description', 'class' => 'form-control', 'rows'=>'4']) !!}
                                        </div>
                                    </div>


                                    <!-- Due Date Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_examination_due_date">Exam Date</label>
                                        <div class="col-sm-2">
                                            {!! Form::text('txt_examination_due_date', null, ['id'=>'txt_examination_due_date', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>


                                    <!-- examination Max Score Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_examination_max_score">Max Score</label>
                                        <div class="col-sm-2">
                                            {!! Form::number('txt_examination_max_score', null, ['id'=>'txt_examination_max_score','min' => '0', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <!-- examination Grade Contribution Pct Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_examination_score_contriution_pct">Grade Contribution(%)</label>
                                        <div class="col-md-8">
                                            {!! Form::number('txt_examination_score_contriution_pct', null, ['id'=>'txt_examination_score_contriution_pct','min'=>'0' ,'placeholder'=>"%",'class' => 'form-control']) !!}
                                            <small id="txt_pct_grade_message"></small>
                                        </div>
                                        
                                    </div>


                                </div>
                                
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-modify-examination" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-132')
<script type="text/javascript">
$(document).ready(function() {

    $('#txt_examination_due_date').datetimepicker({
        //format: 'YYYY-MM-DD HH:mm:ss',
        format: 'YYYY-MM-DD',
        useCurrent: true,
        sideBySide: true
    });

    
    //Show Modal
    $('#btn-show-modify-examination-modal').click(function(){
        $('.spinner1').hide();
        $('#modify-examination-error-div').hide();
        $('#modify-examination-modal').modal('show');
        $('#form-modify-examination').trigger("reset");
        $('#txt_examination_id').val(0);
        let remainingGradePct = {!! json_encode($remainingGradePct) !!}
        $('#txt_examination_score_contriution_pct').attr('max',remainingGradePct);
        $('#txt_pct_grade_message').text("Remaining assignable total percentage grade is " + remainingGradePct);
    });

    //Show Modal for Edit Entry
    $('.btn-edit-modify-examination-modal').click(function(){
        $('#modify-examination-error-div').hide();
        $('#modify-examination-modal').modal('show');
        $('#form-modify-examination').trigger("reset");
        $('.spinner1').hide();
        let itemId = $(this).attr('data-val');
        $('#txt_examination_id').val(itemId);

        //Set title and url
        $('#txt_examination_title').val($('#spn_exam_'+itemId+'_title').html());
        $('#txt_examination_description').val($('#spn_exam_'+itemId+'_desc').html());
        $('#txt_examination_number').val($('#spn_exam_'+itemId+'_num').html());

        $('#txt_examination_max_score').val($('#spn_exam_'+itemId+'_max_points').html());
        $('#txt_examination_score_contriution_pct').val($('#spn_exam_'+itemId+'_contrib').html());
        let remainingGradePct = {!! json_encode($remainingGradePct) !!}
        let pctGrade = $('#txt_examination_score_contriution_pct').val();
        let total = parseInt(pctGrade) + parseInt(remainingGradePct);
        $('#txt_examination_score_contriution_pct').attr('max',total);
        $('#txt_pct_grade_message').text("Remaining assignable total percentage grade is " + total);

        
        $('#txt_examination_due_date').val($('#spn_exam_'+itemId+'_date').html());
    });

    //Delete action
    $('.btn-delete-examination').click(function(e){
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this examination?",
          text: "This is an irriversible action!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            let actionType = "DELETE";
            let endPointUrl = "{{ route('classMaterials.destroy',0) }}"+itemId;

            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('_method', actionType);
            
            $.ajax({
                url:endPointUrl,
                type: "POST",
                data: formData,
                cache: false,
                processData:false,
                contentType: false,
                dataType: 'json',
                success: function(result){
                    if(result.errors){
                        console.log(result.errors)
                    }else{
                        swal("Done!","The Examination has been deleted!","success");
                        location.reload(true);
                    }
                },
            });
          }
        });     
    });

    function save_examinations_details(){

        let actionType = "POST";
        let endPointUrl = "{{ route('classMaterials.store') }}";
        let primaryId = $('#txt_examination_id').val();
        

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('classMaterials.update',0) }}"+primaryId;
        }
        
            let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('type', 'class-examinations');
        formData.append('course_class_id', {{ ($courseClass) ? $courseClass->id : ''}});
        formData.append('examination_number', $('#txt_examination_number').val());
        formData.append('title', $('#txt_examination_title').val());
        formData.append('description', $('#txt_examination_description').val());
        formData.append('due_date', $('#txt_examination_due_date').val());
        formData.append('grade_max_points', $('#txt_examination_max_score').val());
        formData.append('remaining_pct_grade',$('#txt_assignment_score_contriution_pct').attr('max'));
        formData.append('grade_contribution_pct', $('#txt_examination_score_contriution_pct').val());
        formData.append('id', primaryId );

    

        
        

        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(result){
                if(result.errors){

                    $('#modify-examination-error-div').html('');
                    $('#modify-examination-error-div').show();
                    $('.spinner1').hide();
                    $('#btn-modify-examination').prop("disabled", false);
                    $.each(result.errors, function(key, value){
                        $('#modify-examination-error-div').append('<li class="">'+value+'</li>');
                    });

                }else{
                    $('#modify-examination-error-div').hide();
                    $('.spinner1').hide();
                    $('#btn-modify-examination').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!","Examination saved successfully!","success");
                        $('#modify-examination-modal').modal('hide');
                        location.reload(true);
                    }, 50);
                }
            },
        });

    }

    //Save examination
    $('#btn-modify-examination').click(function(e) {
        $('.spinner1').show();
        $('#btn-modify-examination').prop("disabled", true);
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        save_examinations_details();
    });

});
</script>
@endsection
