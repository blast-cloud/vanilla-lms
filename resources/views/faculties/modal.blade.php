

<div class="modal fade" id="mdl-faculty-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-faculty-modal-title" class="modal-title">@if(config('lmsfaculty.faculty',true))<span class="right-nav-text">Faculty</span>
                    @elseif(config('lmsfaculty.school',true))<span class="right-nav-text">School</span>
                    @elseif(config('lmsfaculty.college',true))<span class="right-nav-text">College</span>
                    @else
                    <span class="right-nav-text">Faculty</span>
                    @endif
                </h4>
            </div>

            <div class="modal-body">
                <div id="div-faculty-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-faculty-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div id="spinner1" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-faculty-primary-id" value="0" />
                            <div id="div-show-txt-faculty-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('faculties.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-faculty-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('faculties.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-faculty-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

{{-- Bulk upload modal --}}
<div class="modal fade" id="mdl-bulk-faculty-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-faculty-modal-title" class="modal-title">{{ isset($title) ? "Bulk Upload" : "Bulk Upload" }}</h4>
            </div>

            <div class="modal-body">
                <div id="div-bulk-faculty-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-faculty-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="no-file">Please upload a csv file</span></div>
                            <div id="spinner-faculties" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <div id="div-show-txt-faculty-primary-id">
                                <div class="row">
                                    <div class="col-lg-12 ma-10">                            
                                        <div id="div-bulk_faculty" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="bulk_faculty">Upload CSV</label>
                                            <div class="col-sm-9">
                                                {!! Form::file('bulk_faculty', ['class' => 'custom-file-input', 'id'=>'bulk_faculty']) !!}
                                            </div>
                                        </div>
                                        <span class="badge badge-pill badge-secondary mb-5 ml-30">csv file format:</span>
                                        <a href="{{asset('csv/faculty_upload_csv_format.csv')}}" class="btn btn-sm btn-danger" data-toggle="tootip" title="faculty csv file format"><i class="fa fa-download"></i> Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="div-save-mdl-faculty-modal" class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-bulk-faculty-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {
$('#div-bulk-faculty-modal-error').hide();
$('.no-file').hide();
$('#spinner-faculties').fadeOut(1);

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-faculty-modal", function(e) {
        $('#spinner1').hide();
        $('#div-faculty-modal-error').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('#mdl-faculty-modal').modal('show');
        $('.modal-footer').show();
        $('#frm-faculty-modal').trigger("reset");
        $('#txt-faculty-primary-id').val(0);

        $('#div-show-txt-faculty-primary-id').hide();
        $('#div-edit-txt-faculty-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-faculty-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('#spinner1').hide();
        $('#div-show-txt-faculty-primary-id').show();
        $('#div-edit-txt-faculty-primary-id').hide();
        $('.modal-footer').hide('show');
        let itemId = $(this).attr('data-val');

        $.get( "{{URL::to('/')}}/api/faculties/"+itemId).done(function( response ) {
			$('#div-faculty-modal-error').hide();
			$('#mdl-faculty-modal').modal('show');
			$('#frm-faculty-modal').trigger("reset");
			$('#txt-faculty-primary-id').val(response.data.id);

            $('#spn_faculty_code').html(response.data.code);
            $('#spn_faculty_name').html(response.data.name);   
            $('#spn_faculty_email_address').html(response.data.email_address);
            $('#spn_faculty_website_url').html(response.data.website_url);   
            $('#spn_faculty_contact_phone').html(response.data.contact_phone);

        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-faculty-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('#spinner1').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('#div-show-txt-faculty-primary-id').hide();
        $('#div-edit-txt-faculty-primary-id').show();
        $('.modal-footer').show();
        let itemId = $(this).attr('data-val');

        $.get("{{ route('api.faculties.show','') }}/"+itemId).done(function( response ) {            
			$('#div-faculty-modal-error').hide();
			$('#mdl-faculty-modal').modal('show');
			$('#frm-faculty-modal').trigger("reset");
			$('#txt-faculty-primary-id').val(response.data.id);

            $('#code').val(response.data.code);
            $('#name').val(response.data.name);
            $('#email_address').val(response.data.email_address);
            $('#website_url').val(response.data.website_url);
            $('#contact_phone').val(response.data.contact_phone);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-faculty-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this faculty?",
          text: "This is an irriversible action!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {        
            let endPointUrl = "{{ route('faculties.destroy',0) }}"+itemId;

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
                        swal("Done!", "The faculty record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-faculty-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('#spinner1').show();
        $('#btn-save-mdl-faculty-modal').prop("disabled", true);
        let actionType = "POST";
        let endPointUrl = "{{ route('faculties.store') }}";
        let primaryId = $('#txt-faculty-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('faculties.update',0) }}"+primaryId;
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
					$('#div-faculty-modal-error').html('');
					$('#div-faculty-modal-error').show();
                    $('#spinner1').hide();
                    $('#btn-save-mdl-faculty-modal').prop("disabled", false);
                    
                    $.each(result.errors, function(key, value){
                        $('#div-faculty-modal-error').append('<li class="">'+value+'</li>');
                        $('#'+key).addClass("input-border-error");

                        
                    });
                }else{
                    $('#div-faculty-modal-error').hide();
                    $('#spinner1').hide();
                    $('#btn-save-mdl-faculty-modal').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!", "The faculty record saved successfully.!", "success");
                        // window.alert("The faculty record saved successfully.");
						$('#div-faculty-modal-error').hide();
                        location.reload(true);
                    },28);
                }
            }, error: function(data){
                $('#spinner1').hide();
                $('#btn-save-mdl-faculty-modal').prop("disabled", false);
                console.log(data);
            }
        });
    });

});

$(document).on('click', '#btn-save-mdl-bulk-faculty-modal', function(e) {
    e.preventDefault();
    $('.no-file').hide();
    $("#spinner-faculties").show();
    $(this).attr('disabled', true);

    let formData = new FormData();
    formData.append('_method', "POST");
    endPointUrl = "{{route('api.faculties.bulk')}}";
    @if (isset($organization) && $organization!=null)
        formData.append('organization_id', '{{$organization->id}}');
    @endif
    formData.append('_token', $('input[name="_token"]').val());
    formData.append('parent_id', "");
    formData.append('is_parent',1);
    if ($('#bulk_faculty')[0].files.length > 0) {
        formData.append('bulk_faculty_file', $('#bulk_faculty')[0].files[0]);
        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(result){
                $('spinner-faculties').fadeOut(100);
                $('#btn-save-mdl-bulk-faculty-modal').attr('disabled', false);
                if(result.errors){
                    $('#div-bulk-faculty-modal-error').html('');
                    $('#div-bulk-faculty-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-bulk-faculty-modal-error').append('<li class="">'+value+'</li>');
                        $('#'+key).addClass("input-border-error");

                        $('#'+key).keyup(function(e) {
                            console.log("got here");
                            if($('#'+key).val() != ''){
                                $('#'+key).removeClass("input-border-error")
                            }else{
                                $('#'+key).addClass("input-border-error")
                            }
                        });
                    });
                }else{
                    $('#div-bulk-faculty-modal-error').hide();
                    window.setTimeout( function(){
                        swal("Saved", "faculties saved successfully.", "success");

                        $('#div-bulk-faculty-modal-error').hide();
                        location.reload(true);

                    },20);
                }

                $("#spinner-faculties").hide();
                $("#div-save-mdl-faculty-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-faculties").hide();
                $("#btn-save-mdl-bulk-faculty-modal").attr('disabled', false);

            }
        })
    }else{
        $('#spinner-faculties').fadeOut(100);
        $('.no-file').fadeIn();
        $("#btn-save-mdl-bulk-faculty-modal").attr('disabled', false);
    }
})
</script>
@endsection
