

<div class="modal fade" id="modify-date-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-date-title" class="modal-title">Modify Class Dates</h4>
            </div>

            <div class="modal-body">
                <div id="modify-date-error-div" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="form-modify-date" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-11 ma-10">
                            @csrf
                            
                            <input type="hidden" id="txt_date_id" value="0" />

                                
                            <div class="col-sm-12">

                                <!-- Title Field -->
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_due_date_title">Title</label>
                                    <div class="col-sm-9">
                                        {!! Form::text('txt_due_date_title', null, ['class' => 'form-control','id'=>'txt_due_date_title']) !!}
                                    </div>
                                </div>

                                <!-- Due Date Field -->
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-3" for="txt_due_date_date">Due Date</label>
                                    <div class="col-sm-2">
                                        {!! Form::text('txt_due_date_date', null, ['class' => 'form-control','id'=>'txt_due_date_date']) !!}
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-modify-date" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-112')
<script type="text/javascript">
$(document).ready(function() {

    $('#txt_due_date_date').datetimepicker({
        //format: 'YYYY-MM-DD HH:mm:ss',
        format: 'YYYY-MM-DD',
        useCurrent: true,
        sideBySide: true
    });

    //Show Modal
    $('#btn-show-modify-date-modal').click(function(){
        $('#modify-date-error-div').hide();
        $('#modify-date-modal').modal('show');

        $('#txt_date_id').val(0);
        $('#form-modify-date-modal').trigger("reset");
        $('#txt_due_date_title').val("");
        $('#txt_due_date_date').val("");
    });

    //Show Modal for edit
    $('.btn-edit-modify-date-modal').click(function(){
        $('#modify-date-error-div').hide();
        $('#modify-date-modal').modal('show');
        $('#form-modify-date-modal').trigger("reset");

        let itemId = $(this).attr('data-val');
        $('#txt_date_id').val(itemId);

        //Set title and url
        $('#txt_due_date_title').val($('#spn_dt_'+itemId+'_title').html());
        $('#txt_due_date_date').val($('#spn_dt_'+itemId+'_date').html());        
    });

    //Delete action
    $('.btn-delete-date-entry').click(function(e){
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        if (confirm("Are you sure you want to delete this date?")){
            
            let actionType = "DELETE";
            let endPointUrl = "{{ route('calendarEntries.destroy',0) }}"+itemId;

            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('_method', actionType);
            
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
                        window.alert("The class date has been deleted.");
                        location.reload(true);
                    }
                },
            });
        }


        
    });

    //Save lecturer
    $('#btn-modify-date').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        let actionType = "POST";
        let endPointUrl = "{{ route('calendarEntries.store') }}";
        let primaryId = $('#txt_date_id').val();

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('calendarEntries.update',0) }}"+primaryId;
        }

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('course_class_id', {{ ($courseClass) ? $courseClass->id : ''}});
        formData.append('title', $('#txt_due_date_title').val());
        formData.append('due_date', $('#txt_due_date_date').val());

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

                    $('#modify-date-error-div').html('');
                    $('#modify-date-error-div').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#modify-date-error-div').append('<li class="">'+value+'</li>');
                    });

                }else{
                    $('#modify-date-error-div').hide();
                    window.setTimeout( function(){
                        window.alert("Class date saved successfully.");
                        $('#modify-date-modal').modal('hide');
                        location.reload(true);
                    }, 50);
                }
            },
        }); 
    });

});
</script>
@endsection
