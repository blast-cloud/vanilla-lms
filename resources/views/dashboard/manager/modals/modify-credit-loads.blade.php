<div class="modal fade" id="mdl-credit-load-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-credit-load-modal-title" class="modal-title">Credit Load</h4>
            </div>

            <div class="modal-body">
                <div id="div-credit-load-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-credit-load-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-credit-load-primary-id" value="0" />
                            <div id="div-show-txt-credit-load-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('credit_loads.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-credit-load-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('credit_loads.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-credit-load-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-112')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-credit-load-modal", function(e) {
        $('.spinner1').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('.modal-footer').show();
        $('#div-credit-load-modal-error').hide();
        $('#mdl-credit-load-modal').modal('show');
        $('#frm-credit-load-modal').trigger("reset");
        $('#txt-credit-load-primary-id').val(0);

        $('#div-show-txt-credit-load-primary-id').hide();
        $('#div-edit-txt-credit-load-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-credit-load-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').hide();
        $('.modal-footer').hide();
        $('#div-show-txt-credit-load-primary-id').show();
        $('#div-edit-txt-credit-load-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/credit-loads/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/credit_loads/"+itemId).done(function( response ) {
			$('#div-credit-load-modal-error').hide();
			$('#mdl-credit-load-modal').modal('show');
			$('#frm-credit-load-modal').trigger("reset");
			$('#txt-credit-load-primary-id').val(response.data.id);

            $('#spn_level').html(response.data.level);
            $('#spn_semester_code').html(response.data.semester_code);
            $('#spn_max_credit_load').html(response.data.max_credit_load);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-credit-load-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('.modal-footer').show();
        $('#div-show-txt-credit-load-primary-id').hide();
        $('#div-edit-txt-credit-load-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/credit-loads/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/credit_loads/"+itemId).done(function( response ) {            
			$('#div-credit-load-modal-error').hide();
			$('#mdl-credit-load-modal').modal('show');
			$('#frm-credit-load-modal').trigger("reset");
			$('#txt-credit-load-primary-id').val(response.data.id);
            $('#level').val(response.data.level);
            $('#semester_code').val(response.data.semester_code);
            $('#max_credit_load').val(response.data.max_credit_load);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-credit-load-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this credit load?",
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
            let endPointUrl = "{{ route('credit_loads.destroy',0) }}"+itemId;

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
                        swal("Done!", "The Credit Load record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-credit-load-modal').click(function(e) {
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
        $('#btn-save-mdl-credit-load-modal').prop("disabled", true);
        let actionType = "POST";
        let endPointUrl = "{{ route('credit_loads.store') }}";
        let primaryId = $('#txt-credit-load-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('credit_loads.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }

        formData.append('_method', actionType);
        formData.append('level', $('#level').val());
        formData.append('semester_code', $('#semester_code').val());
        formData.append('max_credit_load',$('#max_credit_load').val());
        formData.append('department_id', '{{$current_user->department_id}}')
        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(data){
                if(data.errors){
					$('#div-credit-load-modal-error').html('');
					$('#div-credit-load-modal-error').show();
                    $('.spinner1').hide();
                    $('#btn-save-mdl-credit-load-modal').prop("disabled", false);
                    $.each(data.errors, function(key, value){
                        $('#div-credit-load-modal-error').append('<li class="">'+value+'</li>');
                        $('#credit-load_'+key).addClass("input-border-error");

                        $('#'+key).keyup(function(e) {
                            if($('#'+key).val() != ''){
                                $('#'+key).removeClass("input-border-error")
                            }else{
                                $('#'+key).addClass("input-border-error")
                            }
                        });
                    });
                }else{
                    $('#div-credit-load-modal-error').hide();
                    $('.spinner1').hide();
                    $('#btn-save-mdl-credit-load-modal').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!", "The Credit Load record saved successfully!", "success");
						$('#div-credit-load-modal-error').hide();
                        location.reload(true);
                    },20);
                }
            }, error: function(data){
                $('#div-credit-load-modal-error').html('');
                $('#div-credit-load-modal-error').show();
                $('#btn-save-mdl-credit-load-modal').prop("disabled", false);
                $('.spinner1').hide();
                console.log(data);
            }
        });
    });

});
</script>
@endsection
