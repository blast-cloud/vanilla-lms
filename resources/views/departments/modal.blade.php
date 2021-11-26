

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

                            <div id="spinner1" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

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

{{-- Bulk upload modal --}}
<div class="modal fade" id="mdl-bulk-department-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-department-modal-title" class="modal-title">{{ isset($title) ? "Bulk Faculty Upload" : "Bulk Department Upload" }}</h4>
            </div>

            <div class="modal-body">
                <div id="div-bulk-department-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-department-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="no-file">Please upload a csv file</span></div>
                            {{-- <div id="spinner-departments" class="">
                                <div class="loader" id="loader-1"></div>
                            </div> --}}

                            <div id="div-show-txt-department-primary-id">
                                <div class="row">
                                    <div class="col-lg-12 ma-10">                            
                                        <div id="div-bulk_department" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="bulk_department">Upload CSV</label>
                                            <div class="col-sm-9">
                                                {!! Form::file('bulk_department', ['class' => 'custom-file-input', 'id'=>'bulk_department']) !!}
                                            </div>
                                        </div>
                                        <span class="badge badge-pill badge-secondary mb-5 ml-30">Department csv file format:</span>
                                        <img src="{{asset('imgs/dept_csv_format.png')}}" class="col-md-9  ml-20" data-toggle="tootip" title="Department csv file format">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="div-save-mdl-department-modal" class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-bulk-department-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {
$('#div-bulk-department-modal-error').hide();
$('.no-file').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-department-modal", function(e) {
        $('#spinner1').hide();
        $('#div-department-modal-error').hide();
        $('#mdl-department-modal').modal('show');
        $('.modal-footer').show();
        $('#frm-department-modal').trigger("reset");
        $('#txt-department-primary-id').val(0);

        $('#div-show-txt-department-primary-id').hide();
        $('#div-edit-txt-department-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-department-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('#spinner1').hide();
        $('#div-show-txt-department-primary-id').show();
        $('#div-edit-txt-department-primary-id').hide();
        $('.modal-footer').hide('show');
        let itemId = $(this).attr('data-val');

        $.get( "{{URL::to('/')}}/api/departments/"+itemId).done(function( response ) {
			$('#div-department-modal-error').hide();
			$('#mdl-department-modal').modal('show');
			$('#frm-department-modal').trigger("reset");
			$('#txt-department-primary-id').val(response.data.id);

            $('#spn_department_code').html(response.data.code);
            $('#spn_department_name').html(response.data.name);   
            $('#spn_department_email_address').html(response.data.email_address);
            $('#spn_department_website_url').html(response.data.website_url);   
            $('#spn_department_contact_phone').html(response.data.contact_phone);

        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-department-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('#spinner1').hide();
        $('#div-show-txt-department-primary-id').hide();
        $('#div-edit-txt-department-primary-id').show();
        $('.modal-footer').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{URL::to('/')}}/api/departments/"+itemId).done(function( response ) {            
			$('#div-department-modal-error').hide();
			$('#mdl-department-modal').modal('show');
			$('#frm-department-modal').trigger("reset");
			$('#txt-department-primary-id').val(response.data.id);

            $('#code').val(response.data.code);
            $('#name').val(response.data.name);
            $('#email_address').val(response.data.email_address);
            $('#website_url').val(response.data.website_url);
            $('#contact_phone').val(response.data.contact_phone);

        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-department-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this Department?",
          text: "This is an irriversible action!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
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
                        swal("Done!", "The Department record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-department-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('#spinner1').show();
        $('#btn-save-mdl-department-modal').prop("disabled", true);
        let actionType = "POST";
        let endPointUrl = "{{ route('departments.store') }}";
        let primaryId = $('#txt-department-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('departments.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        formData.append('code', $('#code').val());
        formData.append('name', $('#name').val());
        formData.append('email_address', $('#email_address').val());
        formData.append('website_url', $('#website_url').val());
        formData.append('contact_phone', $('#contact_phone').val());

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
                    $('#spinner1').hide();
                    $('#btn-save-mdl-department-modal').prop("disabled", false);
                    
                    $.each(result.errors, function(key, value){
                        $('#div-department-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-department-modal-error').hide();
                    $('#spinner1').hide();
                    $('#btn-save-mdl-department-modal').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!", "The Department record saved successfully.!", "success");
                        // window.alert("The Department record saved successfully.");
						$('#div-department-modal-error').hide();
                        location.reload(true);
                    },28);
                }
            }, error: function(data){
                $('#spinner1').hide();
                $('#btn-save-mdl-department-modal').prop("disabled", false);
                console.log(data);
            }
        });
    });

});

$(document).on('click', '#btn-save-mdl-bulk-department-modal', function(e) {
    e.preventDefault();
    $('.no-file').hide();
    $("#spinner-departments").show();
    $(this).attr('disabled', true);

    let formData = new FormData();
    formData.append('_method', "POST");
    endPointUrl = "{{ route('departments.bulk') }}";
    @if (isset($organization) && $organization!=null)
        formData.append('organization_id', '{{$organization->id}}');
    @endif
    formData.append('_token', $('input[name="_token"]').val());
    formData.append('parent_id', '{{ isset($faculty) ? $faculty->id:null }}');
    if ($('#bulk_department')[0].files.length > 0) {
        formData.append('bulk_department_file', $('#bulk_department')[0].files[0]);
        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(result){
                $('#btn-save-mdl-bulk-department-modal').attr('disabled', false);
                if(result.errors){
                    $('#div-bulk-department-modal-error').html('');
                    $('#div-bulk-department-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-bulk-department-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-bulk-department-modal-error').hide();
                    window.setTimeout( function(){
                        swal("Saved", "Departments saved successfully.", "success");

                        $('#div-bulk-department-modal-error').hide();
                        location.reload(true);

                    },20);
                }

                $("#spinner-departments").hide();
                $("#div-save-mdl-department-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-departments").hide();
                $("#btn-save-mdl-bulk-department-modal").attr('disabled', false);

            }
        })
    }else{
        $('.no-file').fadeIn();
        $("#btn-save-mdl-bulk-department-modal").attr('disabled', false);
    }
})
</script>
@endsection
