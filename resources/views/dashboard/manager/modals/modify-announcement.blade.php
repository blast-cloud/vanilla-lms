

<div class="modal fade" id="mdl-announcement-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-announcement-modal-title" class="modal-title">Announcement</h4>
            </div>

            <div class="modal-body">
                <div id="div-announcement-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-announcement-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-announcement-primary-id" value="0" />
                            <div id="div-show-txt-announcement-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('announcements.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-announcement-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('announcements.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-announcement-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-112')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-announcement-modal", function(e) {
        $('.spinner1').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('.modal-footer').show();
        $('#div-announcement-modal-error').hide();
        $('#mdl-announcement-modal').modal('show');
        $('#frm-announcement-modal').trigger("reset");
        $('#txt-announcement-primary-id').val(0);

        $('#div-show-txt-announcement-primary-id').hide();
        $('#div-edit-txt-announcement-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-announcement-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').hide();
        $('.modal-footer').hide();
        $('#div-show-txt-announcement-primary-id').show();
        $('#div-edit-txt-announcement-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/announcements/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/announcements/"+itemId).done(function( response ) {
            const t = (response.data.announcement_end_date).split("-"); 
            const date = new Date(Date.UTC(t[0], t[1]-1, t[2])); 
            const month = (date.getMonth() + 1) < 10 ? `0${(date.getMonth() + 1)}` : `${(date.getMonth() + 1)}`;
            const day = (date.getDate() + 1) < 10 ? `0${(date.getDate())}` : `${(date.getDate())}`;
            const date_value = `${day}-${month}-${date.getUTCFullYear()}`;
			$('#div-announcement-modal-error').hide();
			$('#mdl-announcement-modal').modal('show');
			$('#frm-announcement-modal').trigger("reset");
			$('#txt-announcement-primary-id').val(response.data.id);

            $('#spn_announcement_title').html(response.data.title);
            $('#spn_announcement_end_date').html(date_value);
            $('#spn_announcement_description').html(response.data.description);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-announcement-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('.modal-footer').show();
        $('#div-show-txt-announcement-primary-id').hide();
        $('#div-edit-txt-announcement-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/announcements/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/announcements/"+itemId).done(function( response ) {            
			$('#div-announcement-modal-error').hide();
			$('#mdl-announcement-modal').modal('show');
			$('#frm-announcement-modal').trigger("reset");
			$('#txt-announcement-primary-id').val(response.data.id);

            $('#announcement_title').val(response.data.title);
            $('#announcement_description').val(response.data.description);
            $('#announcement_end_date').val(response.data.announcement_end_date);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-announcement-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this Announcement?",
          text: "This is an irriversible action!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            const wrapper = document.createElement('div');
            wrapper.innerHTML = '<div class="loader2" id="loader-1"></div>';
            swal({
                title: 'Please Wait !',
                content: wrapper, 
                buttons: false,
                closeOnClickOutside: false
            });
            let endPointUrl = "{{ route('announcements.destroy',0) }}"+itemId;

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
                        swal("Done!", "The Announcement record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //handle event for enterkey submission
    $('#title').keypress(function (e) {
     if(e.which == 13) { // the enter key code
        $('#btn-save-mdl-announcement-modal').trigger('click');
        return false;  
      }
    });

    //Save details
    $('#btn-save-mdl-announcement-modal').click(function(e) {
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
        $('#btn-save-mdl-announcement-modal').prop("disabled", true);
        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/announcements/create";
        let endPointUrl = "{{ route('announcements.store') }}";
        let primaryId = $('#txt-announcement-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/announcements/"+itemId;
            endPointUrl = "{{ route('announcements.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }

        formData.append('_method', actionType);
        formData.append('title', $('#announcement_title').val());
        formData.append('description', $('#announcement_description').val());
        formData.append('announcement_end_date', $('#announcement_end_date').val());
        formData.append('department_id', "{{$department->id}}");

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
					$('#div-announcement-modal-error').html('');
					$('#div-announcement-modal-error').show();
                    $('.spinner1').hide();
                    $('#btn-save-mdl-announcement-modal').prop("disabled", false);
                    $.each(data.errors, function(key, value){
                        $('#div-announcement-modal-error').append('<li class="">'+value+'</li>');
                        $('#announcement_'+key).addClass("input-border-error");

                        $('#announcement_'+key).keyup(function(e) {
                            if($('#announcement_'+key).val() != ''){
                                $('#announcement_'+key).removeClass("input-border-error")
                            }else{
                                $('#announcement_'+key).addClass("input-border-error")
                            }
                        });
                    });
                }else{
                    $('#div-announcement-modal-error').hide();
                    $('.spinner1').hide();
                    $('#btn-save-mdl-announcement-modal').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!", "The Announcement record saved successfully!", "success");
                        // window.alert("The Announcement record saved successfully.");
						$('#div-announcement-modal-error').hide();
                        location.reload(true);
                    },20);
                }
            }, error: function(data){
                $('#div-announcement-modal-error').html('');
                $('#div-announcement-modal-error').show();
                $('#btn-save-mdl-announcement-modal').prop("disabled", false);
                $('.spinner1').hide();
                console.log(data);
            }
        });
    });

});
</script>
@endsection
