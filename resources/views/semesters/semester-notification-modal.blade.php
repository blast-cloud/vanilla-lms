
<div class="modal fade" id="notification-semester-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-semester-modal-title" class="modal-title">Semester Notification</h4> 
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

                            <input type="hidden" id="txt-semester-notification-primary-id" value="0" />
                            <div id="div-show-notification-txt-semester-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                       
                                        <!-- Semester notification title -->
                                        <div id="div-title" class="form-group">
                                        </div>
                                        <!-- Semester notification message -->
                                        <div id="div-message" class="form-group">
                                        </div>
                                        <!-- Semester to notification message -->
                                        <div id="div-receivers" class="form-group">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="div-edit-notification-txt-semester-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                        <!-- Semester notification title -->
                                        <div id="div-tit" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="is_current">Notification title</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="title" class = "form-control" id="title" placeholder="Notification title">
                                            </div>
                                        </div>
                                        <!-- Semester notification message -->
                                        <div id="div-mes" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="is_current">Notification message</label>
                                            <div class="col-sm-9">
                                                <textarea name="message" class = "form-control" id="message" placeholder="Notification message" rows="6"></textarea>
                                            </div>
                                        </div>
                                        <!-- Semester to notification message -->
                                        <div id="div-rec" class="form-group">
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
                <button type="button" class="btn btn-primary" id="btn-save-notification-mdl-semester-modal" value="make_current">Process</button>
            </div>

        </div>
    </div>
</div>

@section('js-139')
<script type="text/javascript">
$(document).ready(function() {
    $(document).ready(function() {
      $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-semester-notification-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.modal-footer').hide();
        $('#div-show-notification-txt-semester-primary-id').show();
        $('#div-edit-notification-txt-semester-primary-id').hide();
        let itemId = $(this).attr('data-val');
        $('.spinner1').hide();

        $.get( "{{URL::to('/')}}/notifications/"+itemId).done(function( response ) {
            $('#div-notification-semester-modal-error').hide();
            $('#notification-semester-modal').modal('show');
            $('#frm-notification-semester-modal').trigger("reset");
            
            $('#txt-semester-notification-primary-id').val(response.data.id);
            $('#div-title').html('<h5>Notification Title: </h5><blockquote><article>' + response.data.title + '</article></blockquote>');
            $('#div-message').html('<h5>Notification Message: </h5><blockquote><textarea disabled style="width:100%">' + response.data.message + '</textarea></blockquote>');
            let receiversVar = "";
            if(response.data.managers_receives == '1'){ receiversVar += "All Managers<br>"; }
            if (response.data.lecturers_receives == '1') { receiversVar += "All Lecturers<br>"; }
            if (response.data.students_receives == '1') { receiversVar += "All Students<br>"; } 
            if (response.data.managers_receives == '0' && response.data.lecturers_receives == '0' && response.data.students_receives == '0') { receiversVar += " Nil<br>"; }
            $('#div-receivers').html('<h5>Broadcast for: </h5><blockquote><article>' + receiversVar + '</article></blockquote>');
        });
    });

    //Show Modal for new notification Semester
    $(document).on('click', ".btn-new-mdl-semester-notification-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.input-border-error').removeClass("input-border-error");
        $('#div-show-notification-txt-semester-primary-id').hide();
        $('#div-edit-notification-txt-semester-primary-id').show();
        $('.modal-footer').show();
        $('.spinner1').hide();
        $('#div-notification-semester-modal-error').hide();
        $('#notification-semester-modal').modal('show');
        $('#frm-notification-semester-modal').trigger("reset");
        $('#txt-semester-notification-primary-id').val(0);
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-semester-notification-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this Notification?",
          text: "This is an irriversible action!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            swal({
                title: 'Please Wait...',
                content: 'System is Processing Action!', 
                buttons: false,
                closeOnClickOutside: false
            });
            let endPointUrl = "{{ route('notifications.destroy',0) }}"+itemId;

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
                        swal("Done!", "The Notification record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-semester-notification-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('.input-border-error').removeClass("input-border-error");
        $('#div-show-notification-txt-semester-primary-id').hide();
        $('#div-edit-notification-txt-semester-primary-id').show();
        $('.modal-footer').show();
        let itemId = $(this).attr('data-val');
        $('.spinner1').hide();
        
        $.get( "{{URL::to('/')}}/notifications/"+itemId+'/edit').done(function( response ) {            
                $('#div-notification-semester-modal-error').hide();
                $('#notification-semester-modal').modal('show');
                $('#frm-notification-semester-modal').trigger("reset");
                $('#txt-semester-notification-primary-id').val(response.data.id);
                $('#title').val(response.data.title);
                $('#message').val(response.data.message);
                if(response.data.managers_receives == '1'){
                    $('#managers').prop('checked', true);
                } else {
                    $('#managers').prop('checked', false);
                }

                if(response.data.lecturers_receives == '1'){
                    $('#lecturers').prop('checked', true);
                } else {
                    $('#lecturers').prop('checked', false);
                }

                if(response.data.students_receives == '1'){
                    $('#students').prop('checked', true);
                } else {
                    $('#students').prop('checked', false);
                }

            });
    });


    //Save details notification semester
    $('#btn-save-notification-mdl-semester-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').show();
        $('#btn-save-notification-mdl-semester-modal').prop("disabled", true);  
        let reports = 'added';
        let report = 'add';
        if ($('#txt-semester-notification-primary-id').val()>0){ reports = 'updated'; report = 'update'; }
  swal({
      title: "Process Completing...",
      text: "Please confirm that notification should be " + reports + " to list prepared for broadcast!",
      icon: "warning",
      buttons: [
        "No, don't " + report + " it!",
        'Yes, ' + report + ' notice!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        let actionType = "POST";
        let endPointUrl = "{{ route('notifications.store') }}";
        let primaryId = $('#txt-semester-notification-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('notifications.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }

        formData.append('_method', actionType);
        formData.append('title', $('#title').val());
        formData.append('message', $('#message').val());
        formData.append('semester_id', "{{ $semester->id }}");

        if($('#managers').is(':checked') ){
            formData.append('managers_receives', '1');
        } else {
            formData.append('managers_receives', '0');
        }

        if($('#lecturers').is(':checked') ){
            formData.append('lecturers_receives', '1');
        } else {
            formData.append('lecturers_receives', '0');
        }

        if($('#students').is(':checked') ){
            formData.append('students_receives', '1');
        } else {
            formData.append('students_receives', '0');
        }

        if($('#managers').is(':checked') || $('#lecturers').is(':checked') || $('#students').is(':checked') ){
            formData.append('at_least_one_checked', '1');
        } else {
            formData.append('at_least_one_checked', '0');
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
                        swal("Completed!", "Notification " + reports + " to broadcast list successfully!", "success");
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
