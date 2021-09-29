

<div class="modal fade" id="modify-assignment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-assignment-title" class="modal-title">Assignments</h4>
            </div>

            <div class="modal-body">
                <div id="modify-assignment-error-div" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="form-modify-assignment" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf
                            <input id="txt_assignment_id" type="hidden" value="0" />
                            <div class="form-wrap">
                                
                                <div class="col-sm-12">

                                <div id="spinner" class="">
                                        <div class="loader" id="loader-1"></div>
                                      </div>

                                    <!-- Assignment Number Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_assignment_assignment_number">Assignment Number</label>
                                        <div class="col-sm-2">
                                            {!! Form::number('txt_assignment_assignment_number', null, ['id'=>'txt_assignment_assignment_number','min' => '0', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>


                                    <!-- Title Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_assignment_title">Title</label>
                                        <div class="col-sm-7">
                                            {!! Form::text('txt_assignment_title', null, ['id'=>'txt_assignment_title', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <!-- Description Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_assignment_description">Description</label>
                                        <div class="col-sm-7">
                                            {!! Form::textarea('txt_assignment_description', null, ['id'=>'txt_assignment_description', 'class' => 'form-control', 'rows'=>'4']) !!}
                                        </div>
                                    </div>


                                    <!-- Due Date Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_assignment_due_date">Due Date</label>
                                        <div class="col-sm-2">
                                            {!! Form::text('txt_assignment_due_date', null, ['id'=>'txt_assignment_due_date', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>


                                    <!-- Assignment Max Score Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_assignment_max_score">Max Score</label>
                                        <div class="col-sm-2">
                                            {!! Form::number('txt_assignment_max_score', null, ['id'=>'txt_assignment_max_score', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <!-- Assignment Grade Contribution Pct Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_assignment_score_contriution_pct">Grade Contribution (%)</label>
                                        <div class="col-sm-2">
                                            {!! Form::number('txt_assignment_score_contriution_pct', null, ['id'=>'txt_assignment_score_contriution_pct', 'min' => '0','placeholder'=>"%",'class' => 'form-control']) !!}
                                            <small id="txt_assignment_pct_grade_message"></small>
                                        </div>
                                    </div>

                                    <!-- Assignment Grade Contribution Pct Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_allow_late_submission">Allow Late Submission</label>
                                        <div class="col-sm-2">
                                            {!! Form::checkbox('txt_allow_late_submission', 1, ['id'=>'txt_allow_late_submission',  'class' => 'form-control']) !!}
                                        </div>
                                    </div>


                                    <!-- Upload File Path Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_assignment_upload_file_path">Assignment File</label>
                                        <div class="col-sm-7">
                                            {!! Form::file('txt_assignment_upload_file_path', ['id'=>'txt_assignment_upload_file_path', 'class' => 'custom-file-input']) !!}
                                        </div>
                                    </div>

                                    <!-- Reference Material Url Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_assignment_reference_material_url">Website URL Link</label>
                                        <div class="col-sm-7">
                                            {!! Form::text('txt_assignment_reference_material_url', null, ['id'=>'txt_assignment_reference_material_url', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>



                                </div>
                                
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-modify-assignment" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-130')
<script type="text/javascript">
$(document).ready(function() {

    $('#txt_assignment_due_date').datetimepicker({
        //format: 'YYYY-MM-DD HH:mm:ss',
        format: 'DD-MM-YYYY',
        useCurrent: true,
        sideBySide: true,
        minDate: new Date()
    });

    //Show Modal
    $('#btn-show-modify-assignment-modal').click(function(){
        $('#spinner').hide();
        $('#modify-assignment-error-div').hide();
        $('#modify-assignment-modal').modal('show');
        $('#form-modify-assignment').trigger("reset");
        $('#txt_assignment_id').val(0);
        let remainingGradePct = {!! json_encode($remainingGradePct) !!}
        $('#txt_assignment_score_contriution_pct').attr('max',remainingGradePct);
        $('#txt_assignment_pct_grade_message').text("Remaining assignable total percentage grade is " + remainingGradePct);
    });

    //Show Modal for Edit Entry
    $('.btn-edit-modify-assignment-modal').click(function(){
        $('#modify-assignment-error-div').hide();
        $('#spinner').hide();
        $('#modify-assignment-modal').modal('show');
        $('#form-modify-assignment').trigger("reset");

        let itemId = $(this).attr('data-val');
        $('#txt_assignment_id').val(itemId);
        //Set title and url
        $('#txt_assignment_title').val($('#spn_ass_'+itemId+'_title').html());
        $('#txt_assignment_description').val($('#spn_ass_'+itemId+'_desc').html());
        $('#txt_assignment_assignment_number').val($('#spn_ass_'+itemId+'_num').html());

        $('#txt_assignment_max_score').val($('#spn_ass_'+itemId+'_max_points').html());
        $('#txt_assignment_score_contriution_pct').val($('#spn_ass_'+itemId+'_contrib').html());
        let remainingGradePct = {!! json_encode($remainingGradePct) !!}
        let pctGrade = $('#txt_assignment_score_contriution_pct').val();
        let total = parseInt(pctGrade) + parseInt(remainingGradePct);
        $('#txt_assignment_score_contriution_pct').attr('max',total);
        $('#txt_assignment_pct_grade_message').text("Remaining assignable total percentage grade is " + total);

        $('#txt_allow_late_submission').val($('#spn_ass_'+itemId+'_submission').html());

        $('#txt_assignment_due_date').val($('#spn_ass_'+itemId+'_date').html());
        $('#txt_assignment_reference_material_url').val($('#spn_ass_'+itemId+'_url').html());
    });

    //Delete action
    $('.btn-delete-assignment').click(function(e){
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this assignment?",
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
                        swal("Done!","The Assignment has been deleted!","success");
                        location.reload(true);
                    }
                },
            });
          }
        });      
    });


    function save_assignments_details(fileDetails){
        // alert($("input[name=txt_allow_late_submission]:checked").val())
        $('#spinner').show();
        $('#btn-modify-assignment').prop("disabled", true);
        let actionType = "POST";
        let endPointUrl = "{{ route('classMaterials.store') }}";
        let primaryId = $('#txt_assignment_id').val();
        let allow_late_submission = $("input[name=txt_allow_late_submission]:checked").val();
        if(allow_late_submission == undefined ){
            allow_late_submission = '0';
        }

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('classMaterials.update',0) }}"+primaryId;
        }

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('type', 'class-assignments');
        formData.append('course_class_id', {{ ($courseClass) ? $courseClass->id : ''}});
        formData.append('assignment_number', $('#txt_assignment_assignment_number').val());
        formData.append('title', $('#txt_assignment_title').val());
        formData.append('description', $('#txt_assignment_description').val());
        formData.append('due_date', $('#txt_assignment_due_date').val());
        formData.append('allow_late_submission', allow_late_submission);
        formData.append('remaining_pct_grade',$('#txt_assignment_score_contriution_pct').attr('max'));
        formData.append('id', primaryId );
        formData.append('reference_material_url', $('#txt_assignment_reference_material_url').val());
        if (fileDetails!=null){
            formData.append('upload_file_path', fileDetails[0]);
            formData.append('upload_file_type', fileDetails[1]);
        }
        formData.append('grade_max_points', $('#txt_assignment_max_score').val());
        formData.append('grade_contribution_pct', $('#txt_assignment_score_contriution_pct').val());

        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(result){
                console.log(result);
                return;
                if(result.errors){
                    $('#spinner').hide();
                    $('#btn-modify-assignment').prop("disabled", false);
                    $('#modify-assignment-error-div').html('');
                    $('#modify-assignment-error-div').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#modify-assignment-error-div').append('<li class="">'+value+'</li>');
                    });

                }else{
                    $('#modify-assignment-error-div').hide();
                    $('#spinner').hide();
                    $('#btn-modify-assignment').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!","Assignment saved successfully!","success");
                        $('#modify-assignment-modal').modal('hide');
                        location.reload(true);
                    }, 50);
                }
            },
        });

    }


    //Save assignment
    $('#btn-modify-assignment').click(function(e) {
        e.preventDefault();

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline').fadeIn(300);
            return;
        }else{
            $('.offline').fadeOut(300);
        }
        
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
 
        if ($('#txt_assignment_upload_file_path')[0].files[0] == null){
            
            save_assignments_details(null);

        }else{

            var formData = new FormData();
            formData.append('file', $('#txt_assignment_upload_file_path')[0].files[0]);

            $.ajax({
                url: "{{ route('attachment-upload') }}",
                type: 'POST', processData: false,
                contentType: false, data: formData,
                success: function(data){
                    console.log(data); 
                    save_assignments_details(data.message);
                },
                error: function(data){ 
                    $('#spinner').hide();
                    $('#btn-modify-assignment').prop("disabled", false);
                    console.log(data);
                }
            });
        }
    });



});
</script>
@endsection
