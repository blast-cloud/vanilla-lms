

<div class="modal fade" id="submit-assignment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-assignment-title" class="modal-title">Submit Assignment</h4>
            </div>

            <div class="modal-body">
                <div id="submit-assignment-error-div" class="alert alert-danger" role="alert"></div>

                <div id="submit-assignment-info-div" class="alert alert-info" role="alert">
                    You have already submitted this assignment, submitting another will over-ride the earlier submitted one.
                </div>

                <form class="form-horizontal" id="form-modify-assignment" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf
                            <input id="txt_id_assignment" type="hidden" value="0" />
                            <input id="txt_id_student" type="hidden" value="0" />
                            <input id="txt_id_course_class" type="hidden" value="0" />
                            <input id="txt_id_submitted_assignment" type="hidden" value="0" />
                            <input id="submit_assignment_title" type="hidden" value="" />
                            <div class="form-wrap">
                                
                                <div class="col-sm-12">

                                    
                                    <div id="spinner1" class="">
                                        <div class="loader" id="loader-1"></div>
                                    </div>
  

                                    <!-- Upload File Path Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="submit_assignment_upload_file_path">Assignment File</label>
                                        <div class="col-sm-7">
                                            <input name="submit_assignment_upload_file_path" id="submit_assignment_upload_file_path" type="file" class="custom-file-input">
                                        </div>
                                    </div>



                                </div>
                                
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-submit-assignment" value="add">Click to Submit Assignment</button>
            </div>

        </div>
    </div>
</div>

@section('js-114')
<script type="text/javascript">
$(document).ready(function() {



    //Show Modal
    $('.btn-show-submit-assignment-modal').click(function(){
        $('#spinner1').hide();
        $('#submit-assignment-info-div').hide();
        $('#submit-assignment-error-div').hide();
        $('#submit-assignment-modal').modal('show');
        $('#form-modify-assignment').trigger("reset");

        let itemId = $(this).attr('data-val');
        $('#txt_id_assignment').val(itemId);

        let courseClassId = $(this).attr('data-val-course-class-id');
        $('#txt_id_course_class').val(courseClassId);

        let studentId = $(this).attr('data-val-student-id');
        $('#txt_id_student').val(studentId);

        let submitted_assignment_id = $(this).attr('data-val-submission-id');
        $('#txt_id_submitted_assignment').val(submitted_assignment_id);

        let assignment_title = $(this).attr('data-val-assignment-title');
        $('#submit_assignment_title').val(assignment_title);

        if (submitted_assignment_id>0){
            $('#submit-assignment-info-div').show();
        }
    });



    function save_assignments_details(fileDetails){
        console.log($('#submit_assignment_upload_file_path')[0].files[0]);
        let assignment_file = $('#submit_assignment_upload_file_path')[0].files[0];
        if( assignment_file == undefined) {
            assignment_file = '';
        }
        $('#spinner1').show();
        $('#btn-submit-assignment').prop("disabled", true);
        let actionType = "POST";
        let endPointUrl = "{{ route('submissions.store') }}";
        let primaryId = $('#txt_id_submitted_assignment').val();

        if (primaryId>0){
            $('#submit-assignment-info-div').show();
            actionType = "PUT";
            endPointUrl = "{{ route('submissions.update',0) }}"+primaryId;
        }

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('course_class_id', {{ ($courseClass) ? $courseClass->id : ''}});
        formData.append('student_id', $('#txt_id_student').val());
        formData.append('title', $('#submit_assignment_title').val());
        formData.append('class_material_id', $('#txt_id_assignment').val());
        formData.append('file', assignment_file);
        formData.append('id', primaryId );
        if (fileDetails!=null){
            formData.append('upload_file_path', fileDetails[0]);
            formData.append('upload_file_type', fileDetails[1]);
        }
        

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

                    $('#submit-assignment-error-div').html('');
                    $('#submit-assignment-error-div').show();
                    $('#spinner1').hide();
                    $('#btn-submit-assignment').prop("disabled", false);
                    $.each(result.errors, function(key, value){
                        $('#submit-assignment-error-div').append('<li class="">'+value+'</li>');
                    });

                }else{
                    $('#submit-assignment-error-div').hide();
                    $('#spinner1').hide();
                    $('#btn-submit-assignment').prop("disabled", false);
                    window.setTimeout( function(){
                        window.alert("Assignment saved successfully.");
                        $('#submit-assignment-modal').modal('hide');
                        location.reload(true);
                    }, 50);
                }
            },
        });

    }


    //Save assignment
    $('#btn-submit-assignment').click(function(e) {
        e.preventDefault();
        $('#spinner1').show();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
       
        if ($('#submit_assignment_upload_file_path')[0].files[0] == null){
            
            save_assignments_details(null);
            $('#spinner1').hide();

        }else{

            var formData = new FormData();
            formData.append('file', $('#submit_assignment_upload_file_path')[0].files[0]);

            $.ajax({
                url: "{{ route('attachment-upload') }}",
                type: 'POST', processData: false,
                contentType: false, data: formData,
                success: function(data){
                    console.log(data); 
                    save_assignments_details(data.message);  
                },
                error: function(data){ 
                    console.log(data);
                    $('#spinner1').hide();
                    $('#btn-submit-assignment').prop("disabled", false);
                }
            });
        }
    });



});
</script>
@endsection
