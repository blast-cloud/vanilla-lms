

<div class="modal fade" id="mdl-student-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-student-modal-title" class="modal-title">Student</h4>
            </div>

            <div class="modal-body">
                <div id="div-student-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-student-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span id="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <input type="hidden" id="txt-student-primary-id" value="0" />
                            <div id="div-show-txt-student-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('students.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-student-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('students.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-student-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-student-modal", function(e) {
        $('#div-student-modal-error').hide();
        $('#mdl-student-modal').modal('show');
        $('#frm-student-modal').trigger("reset");
        $('#txt-student-primary-id').val(0);

        $('#div-show-txt-student-primary-id').hide();
        $('#div-edit-txt-student-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-student-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-student-primary-id').show();
        $('#div-edit-txt-student-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/students/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/students/"+itemId).done(function( response ) {
			$('#div-student-modal-error').hide();
			$('#mdl-student-modal').modal('show');
			$('#frm-student-modal').trigger("reset");
			$('#txt-student-primary-id').val(response.data.id);

            // $('#spn_student_').html(response.data.);
            // $('#spn_student_').html(response.data.);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-student-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-student-primary-id').hide();
        $('#div-edit-txt-student-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/students/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/students/"+itemId).done(function( response ) {            
			$('#div-student-modal-error').hide();
			$('#mdl-student-modal').modal('show');
			$('#frm-student-modal').trigger("reset");
			$('#txt-student-primary-id').val(response.data.id);

            // $('#').val(response.data.);
            // $('#').val(response.data.);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-student-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this Student?",
          text: "This is an irriversible action!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            let endPointUrl = "{{ route('students.destroy',0) }}"+itemId;

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
                        swal("Done!", "The Student record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-student-modal').click(function(e) {
        e.preventDefault();

        //check for network connctivity
        if (!window.navigator.onLine) {
            $('#offline').fadeIn(300);
            return;
        }else{
            $('#offline').fadeOut(300);
        }

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/students/create";
        let endPointUrl = "{{ route('students.store') }}";
        let primaryId = $('#txt-student-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/students/"+itemId;
            endPointUrl = "{{ route('students.update',0) }}"+primaryId;
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
					$('#div-student-modal-error').html('');
					$('#div-student-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-student-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-student-modal-error').hide();
                    window.setTimeout( function(){
                        swal("Done!", "The Student record saved successfully!", "success");
						$('#div-student-modal-error').hide();
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
