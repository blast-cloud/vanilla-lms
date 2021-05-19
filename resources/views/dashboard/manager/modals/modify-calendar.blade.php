

<div class="modal fade" id="mdl-calendarEntry-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-calendarEntry-modal-title" class="modal-title">Calendar Entry</h4>
            </div>

            <div class="modal-body">
                <div id="div-calendarEntry-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-calendarEntry-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <input type="hidden" id="txt-calendarEntry-primary-id" value="0" />
                            <div id="div-show-txt-calendarEntry-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('calendar_entries.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-calendarEntry-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('calendar_entries.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-calendarEntry-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-114')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-calendarEntry-modal", function(e) {
        $('#div-calendarEntry-modal-error').hide();
        $('#mdl-calendarEntry-modal').modal('show');
        $('#frm-calendarEntry-modal').trigger("reset");
        $('#txt-calendarEntry-primary-id').val(0);

        $('#div-show-txt-calendarEntry-primary-id').hide();
        $('#div-edit-txt-calendarEntry-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-calendarEntry-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-calendarEntry-primary-id').show();
        $('#div-edit-txt-calendarEntry-primary-id').hide();
        $('.modal-footer').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/calendar_entries/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/calendar_entries/"+itemId).done(function( response ) {
			$('#div-calendarEntry-modal-error').hide();
			$('#mdl-calendarEntry-modal').modal('show');
			$('#frm-calendarEntry-modal').trigger("reset");
			$('#txt-calendarEntry-primary-id').val(response.data.id);

            $('#spn_calendarEntry_title').html(response.data.title);
            $('#spn_calendarEntry_due_date').html(response.data.due_date);
            $('#spn_calendarEntry_description').html(response.data.description);   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-calendarEntry-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-calendarEntry-primary-id').hide();
        $('#div-edit-txt-calendarEntry-primary-id').show();
        $('.modal-footer').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/calendar_entries/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/calendar_entries/"+itemId).done(function( response ) {            
			$('#div-calendarEntry-modal-error').hide();
			$('#mdl-calendarEntry-modal').modal('show');
			$('#frm-calendarEntry-modal').trigger("reset");
			$('#txt-calendarEntry-primary-id').val(response.data.id);

            $('#title').val(response.data.title);
            $('#due_date').val(response.data.due_date);
            $('#description').val(response.data.description);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-calendarEntry-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        if (confirm("Are you sure you want to delete this CalendarEntry?")){

            let endPointUrl = "{{ route('calendar_entries.destroy',0) }}"+itemId;

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
                        window.alert("The CalendarEntry record has been deleted.");
                        location.reload(true);
                    }
                },
            });            
        }
    });

    //Save details
    $('#btn-save-mdl-calendarEntry-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        // let endPointUrl = "{{URL::to('/')}}/api/calendar_entries/create";
        let endPointUrl = "{{ route('calendar_entries.store') }}";
        let primaryId = $('#txt-calendarEntry-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            // endPointUrl = "{{URL::to('/')}}/api/calendar_entries/"+itemId;
            endPointUrl = "{{ route('calendar_entries.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        formData.append('department_id', {{$department->id}});
        formData.append('title', $('#title').val());
        formData.append('due_date', $('#due_date').val());
        formData.append('description', $('#description').val());

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
					$('#div-calendarEntry-modal-error').html('');
					$('#div-calendarEntry-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-calendarEntry-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-calendarEntry-modal-error').hide();
                    window.setTimeout( function(){
                        window.alert("The CalendarEntry record saved successfully.");
						$('#div-calendarEntry-modal-error').hide();
                        location.reload(true);
                    },20);
                }
            }, error: function(data){
                $('#div-calendarEntry-modal-error').html('');
                $('#div-calendarEntry-modal-error').show();

                if (data.responseJSON && data.responseJSON.errors){
                    $.each(data.responseJSON.errors, function(key, value){
                        $('#div-calendarEntry-modal-error').append('<li class="">'+value+'</li>');
                    });
                }
            }
        });
    });

});
</script>
@endsection
