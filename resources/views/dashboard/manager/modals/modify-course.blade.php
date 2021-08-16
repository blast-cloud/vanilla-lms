

<div class="modal fade" id="mdl-course-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-course-modal-title" class="modal-title">Course </h4>
            </div>

            <div class="modal-body">
                <div id="div-course-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-course-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div id="spinner1" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-course-primary-id" value="0" />
                            <div id="div-show-txt-course-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('courses.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-course-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('courses.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-course-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-115')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-course-modal", function(e) {
        $('#spinner1').hide();
        $('#div-course-modal-error').hide();
        $('#mdl-course-modal').modal('show');
        $('#frm-course-modal').trigger("reset");
        $('#txt-course-primary-id').val(0);
        $('.modal-footer').show();

        $('#div-show-txt-course-primary-id').hide();
        $('#div-edit-txt-course-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-course-modal", function(e) {
        $('#spinner1').hide();
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-course-primary-id').show();
        $('#div-edit-txt-course-primary-id').hide();
        $('.modal-footer').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/courses/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/courses/"+itemId).done(function( response ) {
			$('#div-course-modal-error').hide();
			$('#mdl-course-modal').modal('show');
			$('#frm-course-modal').trigger("reset");
			$('#txt-course-primary-id').val(response.data.id);

            $('#spn_course_code').html(response.data.code);
            $('#spn_course_name').html(response.data.name);
            $('#spn_course_credit_hours').html(response.data.credit_hours);
            $('#spn_course_description').html(response.data.description);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-course-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('#spinner1').hide();

        $('#div-show-txt-course-primary-id').hide();
        $('#div-edit-txt-course-primary-id').show();
        $('.modal-footer').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/courses/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/courses/"+itemId).done(function( response ) {            
			$('#div-course-modal-error').hide();
			$('#mdl-course-modal').modal('show');
			$('#frm-course-modal').trigger("reset");
			$('#txt-course-primary-id').val(response.data.id);

            $('#code').val(response.data.code);
            $('#name').val(response.data.name);
            $('#credit_hours').val(response.data.credit_hours);
            $('#description').val(response.data.description);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-course-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this Course?",
          text: "This is an irriversible action!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            let endPointUrl = "{{ route('courses.destroy',0) }}"+itemId;

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
                        swal("Done!", "The Course record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-course-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('#spinner1').show();
        $('#btn-save-mdl-course-modal').prop("disabled", true);
        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/courses/create";
        let endPointUrl = "{{ route('courses.store') }}";
        let primaryId = $('#txt-course-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/courses/"+itemId;
            endPointUrl = "{{ route('courses.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        formData.append('department_id', {{$department->id}});
        formData.append('code', $('#code').val());
        formData.append('name', $('#name').val());
        formData.append('txt_course_primary_id', $('#txt-course-primary-id').val());
        formData.append('description', $('#description').val());
        formData.append('credit_hours', $('#credit_hours').val());

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
					$('#div-course-modal-error').html('');
					$('#div-course-modal-error').show();
                    $('#spinner1').hide();
                    $('#btn-save-mdl-course-modal').prop("disabled", false);
                    $.each(result.errors, function(key, value){
                        $('#div-course-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-course-modal-error').hide();
                    $('#spinner1').hide();
                    $('#btn-save-mdl-course-modal').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!", "The Course record saved successfully!", "success");
                        // window.alert("The Course record saved successfully.");
						$('#div-course-modal-error').hide();
                        location.reload(true);
                    },20);
                }
            }, error: function(data){
                $('#div-course-modal-error').html('');
                $('#div-course-modal-error').show();
                $('#spinner1').hide();
                $('#btn-save-mdl-course-modal').prop("disabled", false);

                if (data.responseJSON && data.responseJSON.errors){
                    $.each(data.responseJSON.errors, function(key, value){
                        $('#div-course-modal-error').append('<li class="">'+value+'</li>');
                    });
                }
            }
        });
    });

});
</script>
@endsection
