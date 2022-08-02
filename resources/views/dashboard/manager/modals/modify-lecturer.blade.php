

<div class="modal fade" id="mdl-lecturer-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-lecturer-modal-title" class="modal-title">Lecturer</h4>
            </div>

            <div class="modal-body">
                <div id="div-lecturer-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-lecturer-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-lecturer-primary-id" value="0" />
                            <div id="div-show-txt-lecturer-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('lecturers.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-lecturer-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('lecturers.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-lecturer-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

{{-- Bulk upload modal --}}
<div class="modal fade" id="mdl-bulk-staff-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-staff-modal-title" class="modal-title">Bulk Staff Upload</h4>
            </div>

            <div class="modal-body">
                <div id="div-bulk-staff-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-staff-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="no-file">Please upload a csv file</span></div>
                            <div id="spinner-staff" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <div id="div-show-txt-staff-primary-id">
                                <div class="row">
                                    <div class="col-lg-12 ma-10">                            
                                        <div id="div-bulk_staff" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="bulk_staff">Upload CSV</label>
                                            <div class="col-sm-9">
                                                {!! Form::file('bulk_staff', ['class' => 'custom-file-input', 'id'=>'bulk_staff']) !!}
                                            </div>
                                        </div>
                                        <span class="badge badge-pill badge-secondary mb-5 ml-30">Staff csv file format:</span>
                                        <img src="{{asset('imgs/staff_csv_format.png')}}" class="col-md-9 ml-20" data-toggle="tootip" title="Staff csv file format">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="div-save-mdl-staff-modal" class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-bulk-staff-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

{{-- password reset --}}
<div class="modal fade" id="lecturer-password-reset-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-user-password-reset-title" class="modal-title">Reset Lecturer Password</h4>
            </div>

            <div class="modal-body">
                <div id="modify-user-password-reset-error-div" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="form-modify-user-password-reset" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span id="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf
                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt_reset_account_id" value="0" />

                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="code">Password</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="text"
                                            id="password"
                                            name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password">
                                        @error('password')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>                    


                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-modify-user-password-reset" value="add">Reset</button>
            </div>

        </div>
    </div>
</div>


@section('js-128')
<script type="text/javascript">
$(document).ready(function() {
$('.no-file').hide();
$("#spinner-staff").fadeOut(1);
$('#div-bulk-staff-modal-error').hide();

    //Hide irrelevant fields
    function hide_unused_fields(){
        $('#div-user_id').hide();
        $('#div-department_id').hide();
        $('#div-picture_file_path').hide();
    }

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-lecturer-modal", function(e) {
        $('#div-lecturer-modal-error').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('#mdl-lecturer-modal').modal('show');
        $('#frm-lecturer-modal').trigger("reset");
        $('#txt-lecturer-primary-id').val(0);
        $('.spinner1').hide();
        $('.modal-footer').show();
        $('#div-show-txt-lecturer-primary-id').hide();
        $('#div-edit-txt-lecturer-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-lecturer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').hide();
        $('.modal-footer').hide();
        $('#div-show-txt-lecturer-primary-id').show();
        $('#div-edit-txt-lecturer-primary-id').hide();
        let itemId = $(this).attr('data-val');
        

        $.get( "{{URL::to('/')}}/api/lecturers/"+itemId).done(function( response ) {
			$('#div-lecturer-modal-error').hide();
			$('#mdl-lecturer-modal').modal('show');
			$('#frm-lecturer-modal').trigger("reset");
			$('#txt-lecturer-primary-id').val(response.data.id);

            $('#spn_lecturer_email').html(response.data.email);
            $('#spn_lecturer_telephone').html(response.data.telephone);
            $('#spn_lecturer_job_title').html(response.data.job_title);
            $('#spn_lecturer_first_name').html(response.data.first_name);
            $('#spn_lecturer_last_name').html(response.data.last_name);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-lecturer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.input-border-error').removeClass("input-border-error");
        $('.spinner1').hide();
        $('.modal-footer').show();
        $('#div-show-txt-lecturer-primary-id').hide();
        $('#div-edit-txt-lecturer-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{URL::to('/')}}/api/lecturers/"+itemId).done(function( response ) {
			$('#div-lecturer-modal-error').hide();
			$('#mdl-lecturer-modal').modal('show');
			$('#frm-lecturer-modal').trigger("reset");
			$('#txt-lecturer-primary-id').val(response.data.id);

            $('#email').val(response.data.email);
            $('#telephone').val(response.data.telephone);
            $('#job_title').val(response.data.job_title);
            $('#first_name').val(response.data.first_name);
            $('#last_name').val(response.data.last_name);

        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-lecturer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this Lecturer?",
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
                title: 'Please Wait !',
                content: wrapper, 
                buttons: false,
                closeOnClickOutside: false
            });
            let endPointUrl = "{{URL::to('/')}}/api/lecturers/"+itemId;

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
                        swal("Done!", "The Lecturer has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-lecturer-modal').click(function(e) {
        e.preventDefault();

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline').fadeIn(300);
            return;
        }else{
            $('.offline').fadeOut(300);
        }
        
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').show();
        $('#btn-save-mdl-lecturer-modal').prop("disabled", true);
        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/lecturers";
        let endPointUrl = "{{ route('lecturers.store') }}";
        let primaryId = $('#txt-lecturer-primary-id').val();

        
        let formData = new FormData();

        if (primaryId>0){
            actionType = "PUT";
            // let endPointUrl = "{{URL::to('/')}}/api/lecturers/"+itemId;
            endPointUrl = "{{ route('lecturers.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }

        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('email', $('#email').val());
        formData.append('telephone', $('#telephone').val());
        formData.append('job_title', $('#job_title').val());
        formData.append('first_name', $('#first_name').val());
        formData.append('last_name', $('#last_name').val());
        formData.append('department_id', {{ $department->id }});


        
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
                    $('.spinner1').hide();
                    $('#btn-save-mdl-lecturer-modal').prop("disabled", false);
					$('#div-lecturer-modal-error').html('');
					$('#div-lecturer-modal-error').show();
                    $.each(result.errors, function(key, value){
                        $('#div-lecturer-modal-error').append('<li class="">'+value+'</li>');
                        $('#'+key).addClass("input-border-error");

                        $('#'+key).keyup(function(e) {
                            if($('#'+key).val() != ''){
                                $('#'+key).removeClass("input-border-error")
                            }else{
                                $('#'+key).addClass("input-border-error")
                            }
                        });
                    });

                }else{
                    $('.spinner1').hide();
                    $('#div-lecturer-modal-error').hide();
                    $('#btn-save-mdl-lecturer-modal').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!", "The Lecturer saved successfully!", "success");
                        // window.alert("The Lecturer saved successfully.");
						$('#div-lecturer-modal-error').hide();
                        location.reload(true);
                    },20);
                }
            },
            error: function(data){
                $('#btn-save-mdl-lecturer-modal').prop("disabled", false);
                console.log(data);
                $('.spinner1').hide();
            }
        });
    });

});

$(document).on('click', '#btn-save-mdl-bulk-staff-modal', function(e) {
    e.preventDefault();
    
    $('.no-file').hide();
    $("#spinner-staff").show();
    $(this).attr('disabled', true);

    let formData = new FormData();
    formData.append('_method', "POST");
    endPointUrl = "{{ route('api.staff.bulk') }}";
    @if (isset($organization) && $organization!=null)
        formData.append('organization_id', '{{$organization->id}}');
    @endif
    formData.append('_token', $('input[name="_token"]').val());
    formData.append('department_id', '{{auth()->user()->department_id ?? null}}');
    if ($('#bulk_staff')[0].files.length > 0) {
        formData.append('bulk_staff_file', $('#bulk_staff')[0].files[0]);
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
                $("#spinner-staff").fadeOut(100);
                $('#btn-save-mdl-bulk-staff-modal').attr('disabled', false);
                if(result.errors){
                    $('#div-bulk-staff-modal-error').html('');
                    $('#div-bulk-staff-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-bulk-staff-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-bulk-staff-modal-error').hide();
                    window.setTimeout( function(){
                        swal("Saved", "Staff saved successfully.", "success");

                        $('#div-bulk-staff-modal-error').hide();
                        location.reload(true);

                    },20);
                }

                $("#spinner-staff").hide();
                $("#div-save-mdl-staff-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-staff").hide();
                $("#btn-save-mdl-bulk-staff-modal").attr('disabled', false);

            }
        })
    }else{
        $("#spinner-staff").fadeOut(100);
        $('.no-file').fadeIn();
        $("#btn-save-mdl-bulk-staff-modal").attr('disabled', false);
    }
   
});

//Show Modal for Password reset
    $(document).on('click', ".btn-lecturer-password-reset-modal", function(e) {
        e.preventDefault();

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).data('val');
        $('#txt_reset_account_id').val(itemId);
        $('.spinner1').hide();
        $('#lecturer-password-reset-modal').modal('show');
        $('#form-modify-user-password-reset').trigger("reset");
        $('#modify-user-password-reset-error-div').hide();

    });

    //Save user password-reset
    $('#btn-modify-user-password-reset').click(function(e) {
        e.preventDefault();

        //check for internet status 
        if (!window.navigator.onLine) {
            $('#offline').fadeIn(300);
            return;
        }else{
            $('#offline').fadeOut(300);
        }

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('#btn-modify-user-password-reset').prop("disabled", true);
        $('.spinner1').show();
        let actionType = "POST";        
        let endPointUrl = "{{ route('api.staff.reset-psw') }}";

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('password', $('#password').val());
        formData.append('id', $('#txt_reset_account_id').val());

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
                    $('#modify-user-password-reset-error-div').html('');
                    $('#modify-user-password-reset-error-div').show();
                    $('#btn-modify-user-password-reset').prop("disabled", false);
                    $('.spinner1').hide();
                    $.each(result.errors, function(key, value){
                        $('#modify-user-password-reset-error-div').append('<li class="">'+value+'</li>');
                    });

                }else{
                    $('#modify-user-password-reset-error-div').hide();
                    $('#btn-modify-user-password-reset').prop("disabled", false);
                    $('.spinner1').hide();
                    window.setTimeout( function(){
                        swal("Done!","User account password reset successfully!","success");
                        $('#modify-user-password-reset-modal').modal('hide');
                        location.reload(true);
                    }, 50);
                }
            },
        });
        
    });
</script>
@endsection