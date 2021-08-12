

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
                <button type="button" class="btn btn-primary" id="btn-modify-user-password-reset" value="add">Save</button>
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

        let itemId = $(this).attr('data-val');
        $('#txt_reset_account_id').val(itemId);
        $('.spinner1').hide();
        $('#modify-user-password-reset-modal').modal('show');
        $('#form-modify-user-password-reset').trigger("reset");
        $('#modify-user-password-reset-error-div').hide();

    });

    //Save user password-reset
    $('#btn-modify-user-password-reset').click(function(e) {
        e.preventDefault();
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
