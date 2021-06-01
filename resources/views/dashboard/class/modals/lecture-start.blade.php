

<div class="modal fade" id="start-lecture-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="start-lecture-title" class="modal-title">Enter Details to Start Lecture</h4>
            </div>

            <div class="modal-body">
                <div id="start-lecture-error-div" class="alert alert-danger" role="alert"></div>

                

                <form class="form-horizontal" id="form-start-lecture" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-11 ma-10">
                            @csrf
                            <input type="hidden" id="txt_lecture_id" value="0" />
                            <!-- Assignment Number Field -->
                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="txt_start_lecture_number">Lecture Number</label>
                                <div class="col-sm-2">
                                    {!! Form::number('txt_start_lecture_number', null, ['id'=>'txt_start_lecture_number', 'class' => 'form-control']) !!}
                                </div>
                            </div>


                            <!-- Title Field -->
                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="txt_start_lecture_title">Lecture Title</label>
                                <div class="col-sm-7">
                                    {!! Form::text('txt_start_lecture_title', null, ['id'=>'txt_start_lecture_title', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                            <!-- Description Field -->
                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="txt_start_lecture_description">Description</label>
                                <div class="col-sm-7">
                                    {!! Form::textarea('txt_start_lecture_description', null, ['id'=>'txt_start_lecture_description', 'class' => 'form-control', 'rows'=>'4']) !!}
                                </div>
                            </div>

                            <!-- Upload File Path Field -->
                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="txt_start_lecture_upload_file_path">Lecture File</label>
                                <div class="col-sm-7">
                                    {!! Form::file('txt_start_lecture_upload_file_path', ['id'=>'txt_start_lecture_upload_file_path', 'class' => 'custom-file-input']) !!}
                                </div>
                            </div>

                            <!-- Reference Material Url Field -->
                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="txt_start_lecture_reference_material_url">Website URL Link</label>
                                <div class="col-sm-7">
                                    {!! Form::text('txt_start_lecture_reference_material_url', null, ['id'=>'txt_start_lecture_reference_material_url', 'class' => 'form-control']) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-start-lecture" value="add">Start Lecture</button>
            </div>

        </div>
    </div>
</div>

@section('js-129')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal
    $('#btn-show-start-lecture-modal').click(function(e){
        $('#start-lecture-error-div').hide();
        $('#start-lecture-modal').modal('show');
        $('#form-start-lecture').trigger("reset");
        $('#txt_lecture_id').val(0);
    });

    //Show Modal for Edit Entry
    $('.btn-edit-start-lecture-modal').click(function(e){
        $('#start-lecture-error-div').hide();
        $('#start-lecture-modal').modal('show');
        $('#form-start-lecture').trigger("reset");

        let itemId = $(this).attr('data-val');
        $('#txt_lecture_id').val(itemId);

        //Set title and url
        $('#txt_start_lecture_description').val($('#spn_ol_'+itemId+'_desc').html());
        $('#txt_start_lecture_title').val($('#spn_ol_'+itemId+'_title').html());
        $('#txt_start_lecture_number').val($('#spn_ol_'+itemId+'_num').html());
        $('#txt_start_lecture_reference_material_url').val($('#spn_ol_'+itemId+'_url').html());
    });

    //Delete action
    $('.btn-delete-lecture').click(function(e){
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        if (confirm("Are you sure you want to delete this lecture?")){

            let actionType = "DELETE";
            let endPointUrl = "{{ route('classMaterials.destroy',0) }}"+itemId;

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
                        window.alert("The Lecture has been deleted.");
                        location.reload(true);
                    }
                },
            });
        }
    });


    //Save lecture
    $('#btn-start-lecture').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let actionType = "POST";
        let endPointUrl = "{{ route('classMaterials.store') }}";
        let primaryId = $('#txt_lecture_id').val();

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('classMaterials.update',0) }}"+primaryId;
        }

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('type', 'lecture-classes');
        formData.append('course_class_id', {{($courseClass) ? $courseClass->id : ''}});
        formData.append('lecture_number', $('#txt_start_lecture_number').val());
        formData.append('title', $('#txt_start_lecture_title').val());
        formData.append('id', primaryId);
        formData.append('description', $('#txt_start_lecture_description').val());
        formData.append('reference_material_url', $('#txt_start_lecture_reference_material_url').val());
        if (primaryId==0){
            formData.append('blackboard_meeting_status', 'new');
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

                    $('#start-lecture-error-div').html('');
                    $('#start-lecture-error-div').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#start-lecture-error-div').append('<li class="">'+value+'</li>');
                    });

                }else{
                    $('#start-lecture-error-div').hide();
                    window.setTimeout( function(){
                        window.alert("Online lecture created, please click Start Online Blackboard to continue.");
                        $('#start-lecture-modal').modal('hide');
                        location.reload(true);
                    }, 50);
                }
            },
        }); 
    });

});
</script>
@endsection
