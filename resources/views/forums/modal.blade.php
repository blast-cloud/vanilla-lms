

<div class="modal fade" id="mdl-forum-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-forum-modal-title" class="modal-title">Forum</h4>
            </div>

            <div class="modal-body">
                <div id="div-forum-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-forum-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <input type="hidden" id="txt-forum-primary-id" value="0" />
                            <div id="div-show-txt-forum-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('forums.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-forum-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('forums.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-forum-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-forum-modal", function(e) {
        $('#div-forum-modal-error').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('#mdl-forum-modal').modal('show');
        $('#frm-forum-modal').trigger("reset");
        $('#txt-forum-primary-id').val(0);

        $('#div-show-txt-forum-primary-id').hide();
        $('#div-edit-txt-forum-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-forum-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-forum-primary-id').show();
        $('#div-edit-txt-forum-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/forums/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/forums/"+itemId).done(function( response ) {
			$('#div-forum-modal-error').hide();
			$('#mdl-forum-modal').modal('show');
			$('#frm-forum-modal').trigger("reset");
			$('#txt-forum-primary-id').val(response.data.id);

            // $('#spn_forum_').html(response.data.);
            // $('#spn_forum_').html(response.data.);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-forum-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.input-border-error').removeClass("input-border-error");
        $('#div-show-txt-forum-primary-id').hide();
        $('#div-edit-txt-forum-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/forums/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/forums/"+itemId).done(function( response ) {            
			$('#div-forum-modal-error').hide();
			$('#mdl-forum-modal').modal('show');
			$('#frm-forum-modal').trigger("reset");
			$('#txt-forum-primary-id').val(response.data.id);

            // $('#').val(response.data.);
            // $('#').val(response.data.);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-forum-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this Forum?",
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
            let endPointUrl = "{{ route('forums.destroy',0) }}"+itemId;

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
                        swal("Done!", "The Forum record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-forum-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/forums/create";
        let endPointUrl = "{{ route('forums.store') }}";
        let primaryId = $('#txt-forum-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/forums/"+itemId;
            endPointUrl = "{{ route('forums.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        // formData.append('', $('#').val());
        // formData.append('', $('#').val());

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
					$('#div-forum-modal-error').html('');
					$('#div-forum-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-forum-modal-error').append('<li class="">'+value+'</li>');
                        $('#'+key).removeClass("input-border-error");
                    });
                }else{
                    $('#div-forum-modal-error').hide();
                    window.setTimeout( function(){
                        // window.alert("The Forum record saved successfully.");
                        swal("Done!", "The Forum record saved successfully!", "success");
						$('#div-forum-modal-error').hide();
                        location.reload(true);
                    },28);
                }
            }, error: function(data){
                console.log(data);
            }
        });
    });

});
</script>
@endsection
