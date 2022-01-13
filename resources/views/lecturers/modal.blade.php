

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
                        <div class="offline-flag"><span id="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf

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
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-lecturer-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-lecturer-modal", function(e) {
        $('#div-lecturer-modal-error').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('#mdl-lecturer-modal').modal('show');
        $('#frm-lecturer-modal').trigger("reset");
        $('#txt-lecturer-primary-id').val(0);

        $('#div-show-txt-lecturer-primary-id').hide();
        $('#div-edit-txt-lecturer-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-lecturer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.input-border-error').removeClass("input-border-error");
        $('#div-show-txt-lecturer-primary-id').show();
        $('#div-edit-txt-lecturer-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/lecturers/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/lecturers/"+itemId).done(function( response ) {
			$('#div-lecturer-modal-error').hide();
			$('#mdl-lecturer-modal').modal('show');
			$('#frm-lecturer-modal').trigger("reset");
			$('#txt-lecturer-primary-id').val(response.data.id);

            // $('#spn_lecturer_').html(response.data.);
            // $('#spn_lecturer_').html(response.data.);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-lecturer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-lecturer-primary-id').hide();
        $('#div-edit-txt-lecturer-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/lecturers/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/lecturers/"+itemId).done(function( response ) {            
			$('#div-lecturer-modal-error').hide();
			$('#mdl-lecturer-modal').modal('show');
			$('#frm-lecturer-modal').trigger("reset");
			$('#txt-lecturer-primary-id').val(response.data.id);

            // $('#').val(response.data.);
            // $('#').val(response.data.);
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
            let endPointUrl = "{{ route('lecturers.destroy',0) }}"+itemId;

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
                        swal("Done!", "The Lecturer record has been deleted!", "success");
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
            $('#offline').fadeIn(300);
            return;
        }else{
            $('#offline').fadeOut(300);
        }

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/lecturers/create";
        let endPointUrl = "{{ route('lecturers.store') }}";
        let primaryId = $('#txt-lecturer-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/lecturers/"+itemId;
            endPointUrl = "{{ route('lecturers.update',0) }}"+primaryId;
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
					$('#div-lecturer-modal-error').html('');
					$('#div-lecturer-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-lecturer-modal-error').append('<li class="">'+value+'</li>');
                        $('#'+key).removeClass("input-border-error");
                    });
                }else{
                    $('#div-lecturer-modal-error').hide();
                    window.setTimeout( function(){
                        // window.alert("The Lecturer record saved successfully.");
                        swal("Done!", "The Lecturer record saved successfully!", "success");
						$('#div-lecturer-modal-error').hide();
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
