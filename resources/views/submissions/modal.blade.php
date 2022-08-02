

<div class="modal fade" id="mdl-submission-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-submission-modal-title" class="modal-title">Submission</h4>
            </div>

            <div class="modal-body">
                <div id="div-submission-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-submission-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <input type="hidden" id="txt-submission-primary-id" value="0" />
                            <div id="div-show-txt-submission-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('submissions.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-submission-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('submissions.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-submission-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-submission-modal", function(e) {
        $('#div-submission-modal-error').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('#mdl-submission-modal').modal('show');
        $('#frm-submission-modal').trigger("reset");
        $('#txt-submission-primary-id').val(0);

        $('#div-show-txt-submission-primary-id').hide();
        $('#div-edit-txt-submission-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-submission-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-submission-primary-id').show();
        $('#div-edit-txt-submission-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/submissions/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/submissions/"+itemId).done(function( response ) {
			$('#div-submission-modal-error').hide();
			$('#mdl-submission-modal').modal('show');
			$('#frm-submission-modal').trigger("reset");
			$('#txt-submission-primary-id').val(response.data.id);

            // $('#spn_submission_').html(response.data.);
            // $('#spn_submission_').html(response.data.);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-submission-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.input-border-error').removeClass("input-border-error");
        $('#div-show-txt-submission-primary-id').hide();
        $('#div-edit-txt-submission-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/submissions/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/submissions/"+itemId).done(function( response ) {            
			$('#div-submission-modal-error').hide();
			$('#mdl-submission-modal').modal('show');
			$('#frm-submission-modal').trigger("reset");
			$('#txt-submission-primary-id').val(response.data.id);

            // $('#').val(response.data.);
            // $('#').val(response.data.);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-submission-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this Submission?",
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
            let endPointUrl = "{{ route('submissions.destroy',0) }}"+itemId;

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
                        swal("Done!", "The Submission record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-submission-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/submissions/create";
        let endPointUrl = "{{ route('submissions.store') }}";
        let primaryId = $('#txt-submission-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/submissions/"+itemId;
            endPointUrl = "{{ route('submissions.update',0) }}"+primaryId;
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
					$('#div-submission-modal-error').html('');
					$('#div-submission-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-submission-modal-error').append('<li class="">'+value+'</li>');
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
                    $('#div-submission-modal-error').hide();
                    window.setTimeout( function(){
                        swal("Done!", "The Submission record saved successfully!", "success");
                        // window.alert("The Submission record saved successfully.");
						$('#div-submission-modal-error').hide();
                        location.reload(true);
                    },20);
                }
            }, error: function(data){
                console.log(data);
            }
        });
    });

});
</script>
@endsection
