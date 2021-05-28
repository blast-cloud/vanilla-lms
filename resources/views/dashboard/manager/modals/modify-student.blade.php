

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
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div id="spinner1" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

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

@section('js-129')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-student-modal", function(e) {
        $('#spinner1').hide();
        $('#div-student-modal-error').hide();
        $('#mdl-student-modal').modal('show');
        $('#frm-student-modal').trigger("reset");
        $('#txt-student-primary-id').val(0);

        $('#div-show-txt-student-primary-id').hide();
        $('#div-edit-txt-student-primary-id').show();
        $('.modal-footer').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-student-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-student-primary-id').show();
        $('#div-edit-txt-student-primary-id').hide();
        $('.modal-footer').hide();
        $('#spinner1').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/students/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/students/"+itemId).done(function( response ) {
			$('#div-student-modal-error').hide();
			$('#mdl-student-modal').modal('show');
			$('#frm-student-modal').trigger("reset");
			$('#txt-student-primary-id').val(response.data.id);

            $('#spn_student_email').html(response.data.email);
            $('#spn_student_first_name').html(response.data.first_name);
            $('#spn_student_last_name').html(response.data.last_name);
            $('#spn_student_telephone').html(response.data.telephone);
            $('#spn_student_matriculation_number').html(response.data.matriculation_number);
            
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-student-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-student-primary-id').hide();
        $('#div-edit-txt-student-primary-id').show();
        $('.modal-footer').show();
        $('#spinner1').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/students/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/students/"+itemId).done(function( response ) {
			$('#div-student-modal-error').hide();
			$('#mdl-student-modal').modal('show');
			$('#frm-student-modal').trigger("reset");
			$('#txt-student-primary-id').val(response.data.id);

            $('#email').val(response.data.email);
            $('#first_name').val(response.data.first_name);
            $('#last_name').val(response.data.last_name);
            $('#telephone').val(response.data.telephone);
            $('#matriculation_number').val(response.data.matriculation_number);

        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-student-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        if (confirm("Are you sure you want to delete this Student?")){

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
                        window.alert("The Student record has been deleted.");
                        location.reload(true);
                    }
                },
            });            
        }
    });

    //Save details
    $('#btn-save-mdl-student-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('#spinner1').show();
        $('#btn-save-mdl-student-modal').prop("disabled", true);
        let actionType = "POST";
        let endPointUrl = "{{ route('students.store') }}";
        let primaryId = $('#txt-student-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('students.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        formData.append('email', $('#email').val());
        formData.append('first_name', $('#first_name').val());
        formData.append('txt_student_primary_id', $('#txt-student-primary-id').val());
        formData.append('last_name', $('#last_name').val());
        formData.append('telephone', $('#telephone').val());
        formData.append('matriculation_number', $('#matriculation_number').val());
        formData.append('department_id', {{ $department->id }});

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
                    $('#spinner1').hide();
                    $('#btn-save-mdl-student-modal').prop("disabled", false);
                    
                    $.each(result.errors, function(key, value){
                        $('#div-student-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-student-modal-error').hide();
                    $('#spinner1').hide();
                    $('#btn-save-mdl-student-modal').prop("disabled", false);
                    window.setTimeout( function(){
                        window.alert("The Student record saved successfully.");
						$('#div-student-modal-error').hide();
                        location.reload(true);
                    },20);
                }
            }, error: function(data){
                $('#spinner1').hide();
                $('#btn-save-mdl-student-modal').prop("disabled", false);
                console.log(data);
            }
        });
    });

});
</script>
@endsection
