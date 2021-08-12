

<div class="modal fade" id="mdl-courseClass-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-courseClass-modal-title" class="modal-title">Course Class</h4>
            </div>

            <div class="modal-body">
                <div id="div-courseClass-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-courseClass-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <input type="hidden" id="txt-courseClass-primary-id" value="0" />
                            <div id="div-show-txt-courseClass-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('course_classes.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-courseClass-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('course_classes.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-courseClass-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-courseClass-modal", function(e) {
        $('#div-courseClass-modal-error').hide();
        $('#mdl-courseClass-modal').modal('show');
        $('#frm-courseClass-modal').trigger("reset");
        $('#txt-courseClass-primary-id').val(0);

        $('#div-show-txt-courseClass-primary-id').hide();
        $('#div-edit-txt-courseClass-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-courseClass-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-courseClass-primary-id').show();
        $('#div-edit-txt-courseClass-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/course_classes/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/course_classes/"+itemId).done(function( response ) {
			$('#div-courseClass-modal-error').hide();
			$('#mdl-courseClass-modal').modal('show');
			$('#frm-courseClass-modal').trigger("reset");
			$('#txt-courseClass-primary-id').val(response.data.id);

            // $('#spn_courseClass_').html(response.data.);
            // $('#spn_courseClass_').html(response.data.);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-courseClass-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-courseClass-primary-id').hide();
        $('#div-edit-txt-courseClass-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/course_classes/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/course_classes/"+itemId).done(function( response ) {            
			$('#div-courseClass-modal-error').hide();
			$('#mdl-courseClass-modal').modal('show');
			$('#frm-courseClass-modal').trigger("reset");
			$('#txt-courseClass-primary-id').val(response.data.id);

            // $('#').val(response.data.);
            // $('#').val(response.data.);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-courseClass-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        if (confirm("Are you sure you want to delete this CourseClass?")){

            let endPointUrl = "{{ route('course_classes.destroy',0) }}"+itemId;

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
                        swal("Done!", "The CourseClass record has been deleted!", "success");
                        // window.alert("The CourseClass record has been deleted.");
                        location.reload(true);
                    }
                },
            });            
        }
    });

    //Save details
    $('#btn-save-mdl-courseClass-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/course_classes/create";
        let endPointUrl = "{{ route('course_classes.store') }}";
        let primaryId = $('#txt-courseClass-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/course_classes/"+itemId;
            endPointUrl = "{{ route('course_classes.update',0) }}"+primaryId;
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
					$('#div-courseClass-modal-error').html('');
					$('#div-courseClass-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-courseClass-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-courseClass-modal-error').hide();
                    window.setTimeout( function(){
                        swal("Done!", "The CourseClass record saved successfully!", "success");
                        // window.alert("The CourseClass record saved successfully.");
						$('#div-courseClass-modal-error').hide();
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
