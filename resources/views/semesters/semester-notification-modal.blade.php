
<div class="modal fade" id="notification-semester-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-semester-modal-title" class="modal-title">Generate & Send Semester Notification</h4> 
                    @if (isset($semester->is_current))
                        @if($semester->is_current == 1)
                            <i><small style="color:green;"><strong>NOTE:</strong> This semester is currently active! </small></i>
                        @elseif ($semester->is_current == 0)
                            <i><small style="color:red;"><strong>NOTE:</strong> This semester is not currently active! </small></i>
                            @if(isset($current_semester))
                                @if(!empty($current_semester))
                                    <br><i><small style="color:green;"><strong>CURRENT SEMESTER:</strong> {{ $current_semester->code }}, {{ $current_semester->academic_session }} Academic Session! </small></i>
                                @endif
                            @endif
                        @endif
                    @endif
            </div>

            <div class="modal-body">
                <div id="div-notification-semester-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-notification-semester-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>
                            <div id="




                            div-notification-txt-semester-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                        <!-- Semester notification title -->
                                        <div id="div-code" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="is_current">Notification title</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="notification_title" class = "form-control" id="notification_title" placeholder="Notification title">
                                            </div>
                                        </div>
                                        <!-- Semester notification message -->
                                        <div id="div-code" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="is_current">Notification message</label>
                                            <div class="col-sm-9">
                                                <textarea name="notification_message" class = "form-control" id="notification_message" placeholder="Notification message" rows="6"></textarea>
                                            </div>
                                        </div>
                                        <!-- Semester to notification message -->
                                        <div id="div-code" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="is_current">Select recepient groups</label>
                                            <div class="col-sm-9">
                                                <div class="col-sm-4">
                                                    <input type="checkbox" name="managers" id="managers"> All Managers
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="checkbox" name="lecturers" id="lecturers"> All Lecturers
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="checkbox" name="students" id="students"> All Students
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-notification-mdl-semester-modal" value="make_current">Proceed</button>
            </div>

        </div>
    </div>
</div>

@section('js-139')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for notification Semester
    $(document).on('click', ".btn-new-mdl-semester-notification-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.input-border-error').removeClass("input-border-error");
        $('#div-notification-txt-semester-primary-id').show();
        $('.modal-footer').show();
        $('.spinner1').hide();
        $('#div-notification-semester-modal-error').hide();
        $('#notification-semester-modal').modal('show');
        $('#frm-notification-semester-modal').trigger("reset");
    });

    //Save details notification semester
    $('#btn-save-notification-mdl-semester-modal').click(function(e) {
        //alert('i am clicked');
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').show();
        $('#btn-save-notification-mdl-semester-modal').prop("disabled", true);
        
  swal({
      title: "Process Completing?",
      text: "Notification will be sent to selected receipients; Are you sartisfied with this action?",
      icon: "warning",
      buttons: [
        "No, don't send it!",
        'Yes, send notice!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        let actionType = "PUT";
        let endPointUrl = "{{ route('semesters.setcurrentsemester', ) }}";
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('is_current', $('#is_current').val());

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
                    $('#div-notification-semester-modal-error').html('');
                    $('#div-notification-semester-modal-error').show();
                    $('.spinner1').hide();
                    $('#btn-save-notification-mdl-semester-modal').prop("disabled", false);
                    
                    $.each(result.errors, function(key, value){
                        $('#div-notification-semester-modal-error').append('<li class="">'+value+'</li>');
                        $('#'+key).addClass("input-border-error");
                    });
                }else{
                    $('.spinner1').hide();
                    $('#btn-save-notification-mdl-semester-modal').prop("disabled", false);
                    $('#div-notification-semester-modal-error').hide();
                    window.setTimeout( function(){
                        swal("Completed!", "New notification scheduled and sent to receipients successfully!", "success");
                        $('#div-notification-semester-modal-error').hide();
                        location.reload(true);
                    },28);
                }
            }, error: function(data){
                $('.spinner1').hide();
                $('#btn-save-notification-mdl-semester-modal').prop("disabled", false);
                console.log(data);
            }
        });

      } else {
        swal("Cancelled", "Notification process undone!", "error");
        $('.spinner1').hide();
        $('#btn-save-notification-mdl-semester-modal').prop("disabled", false);
        //location.reload(true);
      }
    })

    });

});
</script>
@endsection
