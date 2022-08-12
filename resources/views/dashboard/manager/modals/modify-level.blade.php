

<div class="modal fade" id="mdl-level-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-level-modal-title" class="modal-title">Level</h4>
            </div>

            <div class="modal-body">
                <div id="div-level-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-level-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-level-primary-id" value="0" />
                            <div id="div-show-txt-level-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('levels.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-level-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('levels.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-level-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-112')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-level-modal", function(e) {
        $('.spinner1').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('.modal-footer').show();
        $('#div-level-modal-error').hide();
        $('#mdl-level-modal').modal('show');
        $('#frm-level-modal').trigger("reset");
        $('#txt-level-primary-id').val(0);

        $('#div-show-txt-level-primary-id').hide();
        $('#div-edit-txt-level-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-level-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').hide();
        $('.modal-footer').hide();
        $('#div-show-txt-level-primary-id').show();
        $('#div-edit-txt-level-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/levels/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/levels/"+itemId).done(function( response ) {
			$('#div-level-modal-error').hide();
			$('#mdl-level-modal').modal('show');
			$('#frm-level-modal').trigger("reset");
			$('#txt-level-primary-id').val(response.data.id);

            $('#spn_level_name').html(response.data.name);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-level-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('.modal-footer').show();
        $('#div-show-txt-level-primary-id').hide();
        $('#div-edit-txt-level-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/levels/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/levels/"+itemId).done(function( response ) {            
			$('#div-level-modal-error').hide();
			$('#mdl-level-modal').modal('show');
			$('#frm-level-modal').trigger("reset");
			$('#txt-level-primary-id').val(response.data.id);
            $('#name').val(response.data.name);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-level-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this level?",
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
            let endPointUrl = "{{ route('levels.destroy',0) }}"+itemId;

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
                        swal("Done!", "The level record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-level-modal').click(function(e) {
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
        $('#btn-save-mdl-level-modal').prop("disabled", true);
        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/levels/create";
        let endPointUrl = "{{ route('levels.store') }}";
        let primaryId = $('#txt-level-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/levels/"+itemId;
            endPointUrl = "{{ route('levels.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }

        formData.append('_method', actionType);
        formData.append('name', $('#level_name').val());
        formData.append('department_id', "{{optional($department)->id}}");
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
					$('#div-level-modal-error').html('');
					$('#div-level-modal-error').show();
                    $('.spinner1').hide();
                    $('#btn-save-mdl-level-modal').prop("disabled", false);
                    $.each(data.errors, function(key, value){
                        $('#div-level-modal-error').append('<li class="">'+value+'</li>');
                        $('#level_'+key).addClass("input-border-error");

                        $('#'+key).keyup(function(e) {
                            if($('#'+key).val() != ''){
                                $('#'+key).removeClass("input-border-error")
                            }else{
                                $('#'+key).addClass("input-border-error")
                            }
                        });
                    });
                }else{
                    $('#div-level-modal-error').hide();
                    $('.spinner1').hide();
                    $('#btn-save-mdl-level-modal').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!", "The level record saved successfully!", "success");
                        // window.alert("The level record saved successfully.");
						$('#div-level-modal-error').hide();
                        location.reload(true);
                    },20);
                }
            }, error: function(data){
                $('#div-level-modal-error').html('');
                $('#div-level-modal-error').show();
                $('#btn-save-mdl-level-modal').prop("disabled", false);
                $('.spinner1').hide();
                console.log(data);
            }
        });
    });

});
</script>
@endsection
