

<div class="modal fade" id="mdl-semester-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-semester-modal-title" class="modal-title">Semester</h4>
                <i><small class="" style="color:red;">NOTE: Creating or Updating a semester will not affect the current semester until the newly created semester is started.</small></i>
            </div>

            <div class="modal-body">
                <div id="div-semester-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-semester-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-semester-primary-id" value="0" />
                            <!-- <div id="div-show-txt-semester-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    include('semesters.show_fields')
                                    </div>
                                </div>
                            </div> -->
                            <div id="div-edit-txt-semester-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('semesters.fields')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-semester-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-semester-modal", function(e) {
        $('#div-semester-modal-error').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('#mdl-semester-modal').modal('show');
        $('#frm-semester-modal').trigger("reset");
        $('#txt-semester-primary-id').val(0);
        $('.modal-footer').show();
        $('#div-show-txt-semester-primary-id').hide();
        $('#div-edit-txt-semester-primary-id').show();
        $('.spinner1').hide();
    });

    //Show Modal for View
    /*$(document).on('click', ".btn-show-mdl-semester-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.modal-footer').hide();
        $('#div-show-txt-semester-primary-id').show();
        $('#div-edit-txt-semester-primary-id').hide();
        let itemId = $(this).attr('data-val');
        $('.spinner1').hide();

        // $.get( "{{URL::to('/')}}/api/semesters/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/semesters/"+itemId).done(function( response ) {
			$('#div-semester-modal-error').hide();
			$('#mdl-semester-modal').modal('show');
			$('#frm-semester-modal').trigger("reset");
			$('#txt-semester-primary-id').val(response.data.id);
            $('#spn_semester_code').html(response.data.code);
            $('#spn_semester_academic_session').html(response.data.academic_session);
            $('#spn_semester_start_date').html(new Intl.DateTimeFormat('en-GB', { dateStyle: 'long',  }).format(Date.parse(response.data.start_date)));
            $('#spn_semester_end_date').html(new Intl.DateTimeFormat('en-GB', { dateStyle: 'long',  }).format(Date.parse(response.data.end_date))); 
        });
    });*/

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-semester-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.input-border-error').removeClass("input-border-error");
        $('#div-show-txt-semester-primary-id').hide();
        $('#div-edit-txt-semester-primary-id').show();
        $('.modal-footer').show();
        let itemId = $(this).attr('data-val');
        $('.spinner1').hide();
        

        // $.get( "{{URL::to('/')}}/api/semesters/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/semesters/"+itemId).done(function( response ) {            
			$('#div-semester-modal-error').hide();
			$('#mdl-semester-modal').modal('show');
			$('#frm-semester-modal').trigger("reset");
			$('#txt-semester-primary-id').val(response.data.id);
            $('#code').val(response.data.code);
            $('#start_date').val(response.data.start_date);
            $('#end_date').val(response.data.end_date);
            $('#academic_session').val(response.data.academic_session);

        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-semester-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this Semester?",
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
            let endPointUrl = "{{ route('semesters.destroy',0) }}"+itemId;

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
                        swal("Done!", "The Semester record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-semester-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').show();
        $('#btn-save-mdl-semester-modal').prop("disabled", true);

        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/semesters/create";
        let endPointUrl = "{{ route('semesters.store') }}";
        let reports = 'Added';
        let primaryId = $('#txt-semester-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/semesters/"+itemId;
            endPointUrl = "{{ route('semesters.update',0) }}"+primaryId;
            formData.append('id', primaryId);
            reports = 'Updated';
        }
        
        formData.append('_method', actionType);
        formData.append('code', $('#code').val());
        formData.append('start_date', $('#start_date').val());
        formData.append('end_date', $('#end_date').val());
        formData.append('academic_session', $('#academic_session').val());
        //generating uniqueCode
        if ($('#code').val() == "First Semester") {
            formData.append('unique_code', $('#academic_session').val()+'/1');
        } else if ($('#code').val() == "Second Semester") {
            formData.append('unique_code', $('#academic_session').val()+'/2');
        }

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
					$('#div-semester-modal-error').html('');
					$('#div-semester-modal-error').show();
                    $('.spinner1').hide();
                    $('#btn-save-mdl-semester-modal').prop("disabled", false);
                    
                    $.each(result.errors, function(key, value){
                        $('#div-semester-modal-error').append('<li class="">'+value+'</li>');
                        $('#'+key).addClass("input-border-error");
                    });
                }else{
                    $('.spinner1').hide();
                    $('#btn-save-mdl-semester-modal').prop("disabled", false);
                    $('#div-semester-modal-error').hide();
                    window.setTimeout( function(){
                        swal("Done!", "The Semester record " + reports + " successfully!", "success");
                        // window.alert("The Semester record saved successfully.");
						$('#div-semester-modal-error').hide();
                        location.reload(true);
                    },28);
                }
            }, error: function(data){
                $('.spinner1').hide();
                $('#btn-save-mdl-semester-modal').prop("disabled", false);
                console.log(data);
            }
        });
    });

});
</script>
@endsection
