

<div class="modal fade" id="mdl-manager-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-manager-modal-title" class="modal-title">Manager</h4>
            </div>

            <div class="modal-body">
                <div id="div-manager-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-manager-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <input type="hidden" id="txt-manager-primary-id" value="0" />
                            <div id="div-show-txt-manager-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('managers.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-manager-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('managers.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-manager-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-manager-modal", function(e) {
        $('#div-manager-modal-error').hide();
        $('#mdl-manager-modal').modal('show');
        $('#frm-manager-modal').trigger("reset");
        $('#txt-manager-primary-id').val(0);

        $('#div-show-txt-manager-primary-id').hide();
        $('#div-edit-txt-manager-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-manager-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-manager-primary-id').show();
        $('#div-edit-txt-manager-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/managers/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/managers/"+itemId).done(function( response ) {
			$('#div-manager-modal-error').hide();
			$('#mdl-manager-modal').modal('show');
			$('#frm-manager-modal').trigger("reset");
			$('#txt-manager-primary-id').val(response.data.id);

            // $('#spn_manager_').html(response.data.);
            // $('#spn_manager_').html(response.data.);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-manager-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-manager-primary-id').hide();
        $('#div-edit-txt-manager-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/managers/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/managers/"+itemId).done(function( response ) {            
			$('#div-manager-modal-error').hide();
			$('#mdl-manager-modal').modal('show');
			$('#frm-manager-modal').trigger("reset");
			$('#txt-manager-primary-id').val(response.data.id);

            // $('#').val(response.data.);
            // $('#').val(response.data.);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-manager-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this Manager?",
          text: "This is an irriversible action!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            let endPointUrl = "{{ route('managers.destroy',0) }}"+itemId;

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
                        swal("Done!", "The Manager record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-manager-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/managers/create";
        let endPointUrl = "{{ route('managers.store') }}";
        let primaryId = $('#txt-manager-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/managers/"+itemId;
            endPointUrl = "{{ route('managers.update',0) }}"+primaryId;
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
					$('#div-manager-modal-error').html('');
					$('#div-manager-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-manager-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-manager-modal-error').hide();
                    window.setTimeout( function(){
                        // window.alert("The Manager record saved successfully.");
                        swal("Done!", "The Manager record saved successfully!", "success");
						$('#div-manager-modal-error').hide();
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
