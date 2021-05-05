

<div class="modal fade" id="mdl-announcement-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-announcement-modal-title" class="modal-title">Announcement</h4>
            </div>

            <div class="modal-body">
                <div id="div-announcement-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-announcement-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <input type="hidden" id="txt-announcement-primary-id" value="0" />
                            <div id="div-show-txt-announcement-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('announcements.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-announcement-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('announcements.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-announcement-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-announcement-modal", function(e) {
        $('#div-announcement-modal-error').hide();
        $('#mdl-announcement-modal').modal('show');
        $('#frm-announcement-modal').trigger("reset");
        $('#txt-announcement-primary-id').val(0);

        $('#div-show-txt-announcement-primary-id').hide();
        $('#div-edit-txt-announcement-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-announcement-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-announcement-primary-id').show();
        $('#div-edit-txt-announcement-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/announcements/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/announcements/"+itemId).done(function( response ) {
			$('#div-announcement-modal-error').hide();
			$('#mdl-announcement-modal').modal('show');
			$('#frm-announcement-modal').trigger("reset");
			$('#txt-announcement-primary-id').val(response.data.id);

            // $('#spn_announcement_').html(response.data.);
            // $('#spn_announcement_').html(response.data.);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-announcement-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-announcement-primary-id').hide();
        $('#div-edit-txt-announcement-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/announcements/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/announcements/"+itemId).done(function( response ) {            
			$('#div-announcement-modal-error').hide();
			$('#mdl-announcement-modal').modal('show');
			$('#frm-announcement-modal').trigger("reset");
			$('#txt-announcement-primary-id').val(response.data.id);

            // $('#').val(response.data.);
            // $('#').val(response.data.);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-announcement-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        if (confirm("Are you sure you want to delete this Announcement?")){

            let endPointUrl = "{{ route('announcements.destroy',0) }}"+itemId;

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
                        window.alert("The Announcement record has been deleted.");
                        location.reload(true);
                    }
                },
            });            
        }
    });

    //Save details
    $('#btn-save-mdl-announcement-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/announcements/create";
        let endPointUrl = "{{ route('announcements.store') }}";
        let primaryId = $('#txt-announcement-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/announcements/"+itemId;
            endPointUrl = "{{ route('announcements.update',0) }}"+primaryId;
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
					$('#div-announcement-modal-error').html('');
					$('#div-announcement-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-announcement-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-announcement-modal-error').hide();
                    window.setTimeout( function(){
                        window.alert("The Announcement record saved successfully.");
						$('#div-announcement-modal-error').hide();
                        location.reload(true);
                    },20);
                }
            }, error: function(data){
                $('#div-announcement-modal-error').html('');
                $('#div-announcement-modal-error').show();

                if (data.responseJSON && data.responseJSON.errors){
                    $.each(result.errors, function(key, value){
                        $('#div-announcement-modal-error').append('<li class="">'+value+'</li>');
                    });
                }
            }
        });
    });

});
</script>
@endsection
