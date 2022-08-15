

<div class="modal fade" id="modify-user-password-reset-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-user-password-reset-title" class="modal-title">Reset User Password</h4>
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

                            <div class="col-sm-12">
                                <strong>USER CREDENTIALS:</strong>
                                <blockquote class="col-sm-12">
                                        <div class="col-sm-3"> <b>Full name :</b></div>
                                        <div  class="col-sm-9"><i id="fullname_info">/i></div>

                                        <div class="col-sm-3"> <b>Email :</b></div>
                                        <div  class="col-sm-9"><i id="email_info"></i></div>
                                </blockquote>
                            </div><hr>
                            <input type="hidden" id="txt_reset_account_id" value="0" />
                            <div class="form-group col-sm-12">
                                <label class="control-label mb-3 col-sm-3" for="code">New Password</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-10">
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

@section('js-114')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-modify-user-password-reset-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.input-border-error').removeClass("input-border-error");
        let itemId = $(this).attr('data-val');
        $('#txt_reset_account_id').val(itemId);
        $('#modify-user-password-reset-error-div').hide();
        $('#form-modify-user-password-reset').trigger("reset");
        $('.spinner1').show();
        $.get("{{ route('dashboard.user', 0) }}" + itemId).done(function(data) {
            $('.spinner1').hide();
            console.log(data);
            $('#fullname_info').text(data.first_name + ' ' + data.last_name);
            $('#email_info').text(data.email);
            $('#modify-user-password-reset-modal').modal('show');
        });

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
        let primaryId = $('#txt_reset_account_id').val();
        let endPointUrl = "{{ route('dashboard.user-pwd-reset',0) }}"+primaryId;

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('password', $('#password').val());

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
                        $('#'+key).addClass("input-border-error");
                        $('#'+key).keyup(function(e) {
                            console.log("got here");
                            if($('#'+key).val() != ''){
                                $('#'+key).removeClass("input-border-error")
                            }else{
                                $('#'+key).addClass("input-border-error")
                            }
                        });
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

});
</script>
@endsection
