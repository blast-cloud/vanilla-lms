

<div class="modal fade" id="mdl-department-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-department-modal-title" class="modal-title">Department</h4>
            </div>

            <div class="modal-body">
                <div id="div-department-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-department-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <input type="hidden" id="txt-department-primary-id" value="0" />
                            <div id="div-show-txt-department-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('departments.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-department-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('departments.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-department-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-department-modal", function(e) {
        $('#div-department-modal-error').hide();
        $('#mdl-department-modal').modal('show');
        $('#frm-department-modal').trigger("reset");
        $('#txt-department-primary-id').val(0);

        $('#div-show-txt-department-primary-id').hide();
        $('#div-edit-txt-department-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-department-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-department-primary-id').show();
        $('#div-edit-txt-department-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/departments/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/departments/"+itemId).done(function( response ) {
			$('#div-department-modal-error').hide();
			$('#mdl-department-modal').modal('show');
			$('#frm-department-modal').trigger("reset");
			$('#txt-department-primary-id').val(response.data.id);

            // $('#spn_department_').html(response.data.);
            // $('#spn_department_').html(response.data.);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-department-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-department-primary-id').hide();
        $('#div-edit-txt-department-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/departments/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/departments/"+itemId).done(function( response ) {            
			$('#div-department-modal-error').hide();
			$('#mdl-department-modal').modal('show');
			$('#frm-department-modal').trigger("reset");
			$('#txt-department-primary-id').val(response.data.id);

            // $('#').val(response.data.);
            // $('#').val(response.data.);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-department-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        if (confirm("Are you sure you want to delete this Department?")){

            let endPointUrl = "{{ route('departments.destroy',0) }}"+itemId;

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
                        window.alert("The Department record has been deleted.");
                        location.reload(true);
                    }
                },
            });            
        }
    });

    //Save details
    $('#btn-save-mdl-department-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/departments/create";
        let endPointUrl = "{{ route('departments.store') }}";
        let primaryId = $('#txt-department-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/departments/"+itemId;
            endPointUrl = "{{ route('departments.update',0) }}"+primaryId;
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
					$('#div-department-modal-error').html('');
					$('#div-department-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-department-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-department-modal-error').hide();
                    window.setTimeout( function(){
                        window.alert("The Department record saved successfully.");
						$('#div-department-modal-error').hide();
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
