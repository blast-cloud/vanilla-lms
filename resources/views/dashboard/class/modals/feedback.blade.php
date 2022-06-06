<div class="modal fade" id="mdl-feedback-response-modal" tabindex="-1" role="dialog" aria-hidden="true">
    @include("dashboard.class.modals.feedback-response")
</div>

<div class="modal fade" id="mdl-feedback-request-modal" tabindex="-1" role="dialog" aria-hidden="true">
    @include("dashboard.class.modals.feedback-request")
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {
    $('#txt_feedback_request_start_date').datetimepicker({
        //format: 'YYYY-MM-DD HH:mm:ss',
        format: 'YYYY-MM-DD',
        useCurrent: true,
        sideBySide: true,
        minDate: new Date()
    });

    $('#txt_feedback_request_due_date').datetimepicker({
        //format: 'YYYY-MM-DD HH:mm:ss',
        format: 'YYYY-MM-DD',
        useCurrent: true,
        sideBySide: true,
        minDate: new Date()
    });

//Show Modal for Feedback Request
$(document).on('click', ".btn-show-feedback-request-modal", function(e) {
    $('.spinner').hide();
    $('#div-feedback-request-modal-error').hide();
    $('#mdl-feedback-request-modal').modal('show');
    $('.modal-footer').show();
    $('#frm-feedback-request-modal').trigger("reset");
    $('#txt-feedback-request-primary-id').val(0);

    $('#div-show-txt-feedback-request-primary-id').hide();
    $('#div-edit-txt-feedback-request-primary-id').show();

    let creatorId = $(this).attr('data-val-creator-id')
    $('#txt_creator_user_id').val(creatorId)

    let departmentId = $(this).attr('data-val-department-id')
    $('#txt_department_id').val(departmentId)
});

//Edit Modal for Feedback Request
$(document).on('click', ".btn-edit-feedback-request-modal", function(e) {
    e.preventDefault();
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
    $('.spinner').hide();
    $('#div-show-txt-feedback-request-primary-id').hide();
    $('#div-edit-txt-feedback-request-primary-id').show();
    $('#div-feedback-request-modal-error').hide();
    $('#mdl-feedback-request-modal').modal('show');
    $('#frm-feedback-request-modal').trigger("reset");
    $('.modal-footer').show();

    let itemId = $(this).attr('data-val-edit-feedback');
    $('#txt-feedback-request-primary-id').val(itemId);

    //Set Title and URL
    $('#txt_feedback_request_start_date').val($('#spn_start_'+itemId+'_date').html());
    $('#txt_feedback_request_due_date').val($('#spn_due_'+itemId+'_date').html());
    $('#txt_feedback_request_remarks').val($('#spn_'+itemId+'_remarks').html());
});

//Delete Modal for Feedback Request
$(document).on('click', ".btn-delete-feedback-request-modal", function(e) {
    e.preventDefault();
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

    let feedbackId = $(this).attr('data-val-delete-feedback');
    swal({
        title: "Are you sure you want to delete this request?",
        text: "This is an irriversible action!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = '<div class="loader2" id="loader-1"></div>';
        swal({
            title: 'Please Wait!',
            content: wrapper, 
            buttons: false,
            closeOnClickOutside: false
        });
        let actionType = "DELETE";
        let endPointUrl = "{{ route('api.course_class_feedbacks.destroy',0) }}"+feedbackId;

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
                    swal("Done!", "Your Request have been deleted successfully!", "success");
                    location.reload(true);
                }
            },
        });
        }
    });
});

//Save Action for Feedback Request
$('#btn-save-feedback-request-modal').click(function(e) {
    e.preventDefault();
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

    $('.spinner').show();
    let actionType = "POST";
    let endPointUrl = "{{ route('api.course_class_feedbacks.store') }}";
    let primaryId = $('#txt-feedback-request-primary-id').val();

    if (primaryId>0){
        actionType = "PUT";
        endPointUrl = "{{ route('api.course_class_feedbacks.update',0) }}"+primaryId;
    }

    let formData = new FormData();
    formData.append('_token', $('input[name="_token"]').val());
    formData.append('_method', actionType);
    formData.append('course_class_id', {{ ($courseClass) ? $courseClass->id : ''}});
    formData.append('creator_user_id',$('#txt_creator_user_id').val());
    formData.append('department_id', $('#txt_department_id').val())
    formData.append('note', $('#txt_feedback_request_remarks').val());
    formData.append('start_date', $('#txt_feedback_request_start_date').val());
    formData.append('end_date', $('#txt_feedback_request_due_date').val());
    formData.append('id', $('#txt-feedback-request-primary-id').val());
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
                $('#div-feedback-request-modal-error').html('');
                $('#div-feedback-request-modal-error').show();
                $('.spinner').hide();
                $('#btn-save-feedback-request-modal').prop("disabled", false);
                
                $.each(result.errors, function(key, value){
                    $('#div-feedback-request-modal-error').append('<li class="">'+value+'</li>');
                });
            }else{
                $('#div-feedback-request-modal-error').hide();
                $('.spinner').hide();
                $('#btn-save-feedback-request-modal').prop("disabled", false);
                window.setTimeout(function(){                      
                    swal("Done!", "Your Request Have Been Sent Successfully.", "success");
                    $('#div-feedback-response-modal-error').hide();
                    location.reload(true);
                },1000);
            }
        }, error: function(data){
            $('.spinner').hide();
            $('#btn-save-feedback-response-modal').prop("disabled", false);
            console.log(data);
        }
    }); 
});


//Show Modal for Feedback Response
$(document).on('click', ".btn-show-feedback-response-modal", function(e) {
    $('.spinner').hide();
    $('#div-feedback-response-modal-error').hide();
    $('#mdl-feedback-response-modal').modal('show');
    $('.modal-footer').show();
    $('#frm-feedback-response-modal').trigger("reset");
    $('#txt-feedback-response-primary-id').val(0);

    $('#div-show-txt-feedback-response-primary-id').hide();
    $('#div-edit-txt-feedback-response-primary-id').show();

    let feedbackrequestId = $(this).attr('data-val-feedback-request-id')
    $('#txt_feedback_request_id').val(feedbackrequestId)

    let studentId = $(this).attr('data-val-student-id')
    $('#txt_student_id').val(studentId)

});

//View Modal Feedback Response
$(document).on('click', ".btn-view-feedback-response-modal", function(e) {
    e.preventDefault();
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
    $('.spinner').hide();
    $('#div-show-txt-feedback-response-primary-id').show();
    $('#div-edit-txt-feedback-response-primary-id').hide();
    $('.modal-footer').hide('show');
    let itemId = $(this).attr('data-val');

    $.get( "{{URL::to('/')}}/api/feedbacks/"+itemId).done(function( response ) {
        $('#div-feedback-response-modal-error').hide();
        //$('#mdl-feedback-response-modal').modal('show');
        $('#frm-feedback-response-modal').trigger("reset");
        $('#txt-feedback-response-primary-id').val(response.data.id);
    });
});

//Edit Modal for Feedback Response
$(document).on('click', ".btn-edit-feedback-response-modal", function(e) {
    e.preventDefault();
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
    $('.spinner').hide();
    $('#div-show-txt-feedback-response-primary-id').hide();
    $('#div-edit-txt-feedback-response-primary-id').show();
    $('#div-feedback-response-modal-error').hide();
    $('#mdl-feedback-response-modal').modal('show');
    $('#frm-feedback-response-modal').trigger("reset");
    $('.modal-footer').show();

    let itemId = $(this).attr('data-val-edit-feedback');
    $('#txt-feedback-response-primary-id').val(itemId);
});

//Delete Modal for Feedback Response
$(document).on('click', ".btn-delete-feedback-response-modal", function(e) {
    e.preventDefault();
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

    let itemId = $(this).attr('data-val');
    swal({
        title: "Are you sure you want to delete your Feedback Response?",
        text: "This is an irriversible action!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
        swal({
            title: 'Please Wait !',
            content: wrapper, 
            buttons: false,
            closeOnClickOutside: false
        });
        let endPointUrl = "";

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', 'DELETE');
        
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
                    swal("Done!", "Your Feedback Response have been deleted successfully!", "success");
                    location.reload(true);
                }
            },
        });
        }
    });
});

//Save Action for Feedback Response
$('#btn-save-feedback-response-modal').click(function(e) {
    e.preventDefault();
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

    swal({
        title: "Is your response confirmed before submission?",
        icon: "warning",
        buttons: ['No', 'Yes'],
            }).then(function(isConfirm) {
                if(isConfirm){   
                    $('.spinner').show();
                    let actionType = "POST";
                    let endPointUrl = "{{ route('api.course_class_feedback_responses.store') }}";
                    let primaryId = $('#txt-feedback-response-primary-id').val();
                    
                    if (primaryId>0){
                        actionType = "PUT";
                        endPointUrl = "{{ route('api.course_class_feedback_responses.update',0) }}"+primaryId;
                    }

                        let formData = new FormData();
                        formData.append('_token', $('input[name="_token"]').val());
                        formData.append('_method', actionType);
                        formData.append('course_class_feedback_id', $('#txt_feedback_request_id').val());
                        formData.append('student_id', $('#txt_student_id').val());
                        formData.append('course_class_id', {{ ($courseClass) ? $courseClass->id : ''}});
                        formData.append('department_id', {{ ($courseClass) ? $courseClass->department_id : ''}});
                        formData.append('lecturer_id', {{ ($courseClass) ? $courseClass->lecturer_id : ''}});
                        formData.append('semester_id', {{($courseClass) ? $courseClass->semester_id : ''}});
                        formData.append('note', $('#txt_feedback_response_remarks').val());
                        formData.append('assignments_rating_point', parseInt($('#txt_feedback_response_assignment_rating').val()));
                        formData.append('clarification_rating_point', parseInt($('#txt_feedback_response_clarification_rating').val()));
                        formData.append('examination_rating_point', parseInt($('#txt_feedback_response_examination_rating').val()));
                        formData.append('teaching_rating_point', parseInt($('#txt_feedback_response_teaching_rating').val()));
                        formData.append('id', $('#txt-feedback-response-primary-id').val());
                    
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
                                $('#div-feedback-response-modal-error').html('');
                                $('#div-feedback-response-modal-error').show();
                                $('.spinner').hide();
                                $('#btn-save-feedback-response-modal').prop("disabled", false);
                                
                                $.each(result.errors, function(key, value){
                                    $('#div-feedback-response-modal-error').append('<li class="">'+value+'</li>');
                                });
                            }else{
                                $('#div-feedback-response-modal-error').hide();
                                $('.spinner').hide();
                                $('#btn-save-feedback-response-modal').prop("disabled", false);
                                window.setTimeout( function(){
                                    swal("Done!","Your Response Have Been Received. Thank You!", "success");
                                    $('#div-feedback-response-modal-error').hide();
                                    location.reload(true);
                                },28);
                            }
                        }, error: function(data){
                            $('.spinner').hide();
                            $('#btn-save-feedback-response-modal').prop("disabled", false);
                            console.log(data);
                        }        
                    }); 
                }
            });
       });
  });
</script>
@endsection
