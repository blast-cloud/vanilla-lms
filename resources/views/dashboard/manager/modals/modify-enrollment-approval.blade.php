

<div class="modal fade" id="mdl-enrollment-approval-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-enrollment-approval-modal-title" class="modal-title">enrollment-approval</h4>
            </div>

            <div class="modal-body">
                <div id="div-enrollment-approval-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-enrollment-approval-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-enrollment-approval-primary-id" value="0" />
                            <div id="div-code" class="form-group">
                            <div id="enrollment_details"  style="padding-left: 120px">

                            </div>
                            </div>
                            <div id="div-code" class="form-group">
                                <label class="control-label col-sm-3" for="code">Change Status</label>
                                <div class="col-sm-4">
                                    <select name="is_approved" id="is_approved" class="form-control">
                                        <option value="0">
                                            Decline
                                        </option>
                                        <option value="1">
                                            Approve
                                        </option>
                                    </select>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-enrollment-approval-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-131')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-enrollment-approval-modal", function(e) {
        $('.spinner1').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('.modal-footer').show();
        $('#div-enrollment-approval-modal-error').hide();
        $('#mdl-enrollment-approval-modal').modal('show');
        $('#frm-enrollment-approval-modal').trigger("reset");
        $('#txt-enrollment-approval-primary-id').val(0);

        $('#div-show-txt-enrollment-approval-primary-id').hide();
        $('#div-edit-txt-enrollment-approval-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-enrollment-approval-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').show();
        //$('.modal-footer').hide();
        $('.modal-footer').show();
        $('#div-show-txt-enrollment-approval-primary-id').show();
        $('#div-edit-txt-enrollment-approval-primary-id').hide();
        let itemId = $(this).attr('data-val');
        console.log(itemId);

        // $.get( "{{URL::to('/')}}/api/enrollment-approvals/"+itemId).done(function( data ) {
            $('#enrollment_details').empty()
        $.get( "{{URL::to('/')}}/api/enrollments/"+itemId).done(function( response ) {
			$('#div-enrollment-approval-modal-error').hide();
			$('#mdl-enrollment-approval-modal').modal('show');
			$('#frm-enrollment-approval-modal').trigger("reset");
			$('#txt-enrollment-approval-primary-id').val(response.data.id);

            $('#enrollment_details').append('<h5> <b>Student Name:</b> '+response.data.student.first_name +' '+response.data.student.last_name+'</h5><br>');
            $('#enrollment_details').append('<h5> <b>Student Name:</b> '+response.data.student.matriculation_number +'</h5><br>');
            $('#enrollment_details').append('<h5> <b>Course Class:</b> '+response.data.course_class.code +' '+response.data.course_class.name+'</h5><br>');     
        });
        $('.spinner1').hide();
    });




    //Save details
    $('#btn-save-mdl-enrollment-approval-modal').click(function(e) {
        e.preventDefault();

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline').fadeIn(300);
            return;
        }else{
            $('.offline').fadeOut(300);
        }

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').show();
        $('#btn-save-mdl-enrollment-approval-modal').prop("disabled", true);
       
        // let endPointUrl = "{{URL::to('/')}}/api/enrollment-approvals/create";
        let primaryId = $('#txt-enrollment-approval-primary-id').val();
        let endPointUrl = "{{URL::to('/')}}/api/enrollments/approval/"+primaryId;
        let actionType="PUT";
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());  
        formData.append('id', primaryId);
      
        formData.append('_method', actionType);
        formData.append('is_approved', $('#is_approved').val());

        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(data){
                if(data.errors){
					$('#div-enrollment-approval-modal-error').html('');
					$('#div-enrollment-approval-modal-error').show();
                    $('.spinner1').hide();
                    $('#btn-save-mdl-enrollment-approval-modal').prop("disabled", false);
                    $.each(data.errors, function(key, value){
                        $('#div-enrollment-approval-modal-error').append('<li class="">'+value+'</li>');
                        $('#'+key).addClass("input-border-error");
                    });
                }else{
                    $('#div-enrollment-approval-modal-error').hide();
                    $('.spinner1').hide();
                    $('#btn-save-mdl-enrollment-approval-modal').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!", "The enrollment approval record saved successfully!", "success");
                        // window.alert("The enrollment-approval record saved successfully.");
						$('#div-enrollment-approval-modal-error').hide();
                        location.reload(true);
                    },200);
                }
            }, error: function(data){
                $('#div-enrollment-approval-modal-error').html('');
                $('#div-enrollment-approval-modal-error').show();
                $('#btn-save-mdl-enrollment-approval-modal').prop("disabled", false);
                $('.spinner1').hide();
                console.log(data);
            }
        });
    });

});
</script>
@endsection
