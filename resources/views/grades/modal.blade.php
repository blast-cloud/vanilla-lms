

<div class="modal fade" id="mdl-grade-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-grade-modal-title" class="modal-title">Grade</h4>
            </div>

            <div class="modal-body">
                <div id="div-grade-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-grade-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <input type="hidden" id="txt-grade-primary-id" value="0" />
                            <div id="div-show-txt-grade-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('grades.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-grade-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('grades.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-grade-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-grade-modal", function(e) {
        $('#div-grade-modal-error').hide();
        $('#mdl-grade-modal').modal('show');
        $('#frm-grade-modal').trigger("reset");
        $('#txt-grade-primary-id').val(0);

        $('#div-show-txt-grade-primary-id').hide();
        $('#div-edit-txt-grade-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-grade-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-grade-primary-id').show();
        $('#div-edit-txt-grade-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/grades/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/grades/"+itemId).done(function( response ) {
			$('#div-grade-modal-error').hide();
			$('#mdl-grade-modal').modal('show');
			$('#frm-grade-modal').trigger("reset");
			$('#txt-grade-primary-id').val(response.data.id);

            // $('#spn_grade_').html(response.data.);
            // $('#spn_grade_').html(response.data.);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-grade-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-grade-primary-id').hide();
        $('#div-edit-txt-grade-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/grades/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/grades/"+itemId).done(function( response ) {            
			$('#div-grade-modal-error').hide();
			$('#mdl-grade-modal').modal('show');
			$('#frm-grade-modal').trigger("reset");
			$('#txt-grade-primary-id').val(response.data.id);

            // $('#').val(response.data.);
            // $('#').val(response.data.);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-grade-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        if (confirm("Are you sure you want to delete this Grade?")){

            let endPointUrl = "{{ route('grades.destroy',0) }}"+itemId;

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
                        swal("Done!", "The Grade record has been deleted!", "success");
                        // window.alert("The Grade record has been deleted.");
                        location.reload(true);
                    }
                },
            });            
        }
    });

    //Save details
    $('#btn-save-mdl-grade-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/grades/create";
        let endPointUrl = "{{ route('grades.store') }}";
        let primaryId = $('#txt-grade-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/grades/"+itemId;
            endPointUrl = "{{ route('grades.update',0) }}"+primaryId;
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
					$('#div-grade-modal-error').html('');
					$('#div-grade-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-grade-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-grade-modal-error').hide();
                    window.setTimeout( function(){
                        // window.alert("The Grade record saved successfully.");
                        swal("Done!", "The Grade record saved successfully!", "success");
						$('#div-grade-modal-error').hide();
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
