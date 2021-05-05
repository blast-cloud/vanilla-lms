

<div class="modal fade" id="modify-announcement-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-announcement-title" class="modal-title">Announcement</h4>
            </div>

            <div class="modal-body">
                <div id="modify-announcement-error-div" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="form-modify-announcement" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <input id="txt_announcement_id" value="0" type="hidden" />
                                                        
                            <div class="form-wrap">
                                
                                <div class="col-sm-11">
                                    <!-- Title Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-2" for="txt_announcement_titles">Title</label>
                                        <div class="col-sm-9">
                                            {!! Form::text('txt_announcement_title', null, ['id'=>'txt_announcement_title','class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <!-- Description Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-2" for="txt_announcement_description"></label>
                                        <div class="col-sm-9">
                                            {!! Form::textarea('txt_announcement_description', null, ['id'=>'txt_announcement_description','rows'=>'4','class' => 'form-control']) !!}
                                        </div>
                                    </div>


                                </div>
                                
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-modify-announcement" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-111')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal
    $('#btn-show-modify-announcement-modal').click(function(){
        $('#modify-announcement-error-div').hide();
        $('#modify-announcement-modal').modal('show');
        $('#form-modify-announcement').trigger("reset");
        $('#txt_announcement_id').val(0);
    });

    //Show Modal for Edit Entry
    $('.btn-edit-modify-announcement-modal').click(function(){
        $('#modify-announcement-error-div').hide();
        $('#modify-announcement-modal').modal('show');
        $('#form-modify-announcement').trigger("reset");

        let itemId = $(this).attr('data-val');
        $('#txt_announcement_id').val(itemId);

        //Set title and description
        $('#txt_announcement_title').val($('#spn_announcement_'+itemId+'_title').html());
        $('#txt_announcement_description').val($('#spn_announcement_'+itemId+'_desc').html());

    });

    //Delete action
    $('.btn-delete-announcement').click(function(e){
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        if (confirm("Are you sure you want to delete this announcement?")){

            let actionType = "DELETE";
            let endPointUrl = "{{ route('announcements.destroy',0) }}"+itemId;

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
                        window.alert("The Announcement has been deleted.");
                        location.reload(true);
                    }
                },
            });
        }
        
    });    


    //Save lecturer
    $('#btn-modify-announcement').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        let endPointUrl = "{{ route('announcements.store') }}";
        let primaryId = $('#txt_announcement_id').val();

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('announcements.update',0) }}"+primaryId;
        }        

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('course_class_id', {{$courseClass->id}});
        formData.append('title', $('#txt_announcement_title').val());
        formData.append('description', $('#txt_announcement_description').val());

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

                    $('#modify-announcement-error-div').html('');
                    $('#modify-announcement-error-div').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#modify-announcement-error-div').append('<li class="">'+value+'</li>');
                    });

                }else{
                    $('#modify-announcement-error-div').hide();
                    window.setTimeout( function(){
                        window.alert("Announcement saved successfully.");
                        $('#modify-announcement-modal').modal('hide');
                        location.reload(true);
                    }, 50);
                }
            },
        }); 
    });

});
</script>
@endsection
