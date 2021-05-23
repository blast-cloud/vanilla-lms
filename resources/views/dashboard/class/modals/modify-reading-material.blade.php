

<div class="modal fade" id="modify-reading-material-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-reading-material-title" class="modal-title">Modify Reading Materials</h4>
            </div>

            <div class="modal-body">
                <div id="modify-reading-material-error-div" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="form-modify-reading-material" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <input type="hidden" id="txt_reading_material_id" value="0" />
                                                        
                            <div class="form-wrap">
                                
                                <div class="col-sm-10">
                                    <!-- Title Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_reading_material_title">Title</label>
                                        <div class="col-sm-9">
                                            {!! Form::text('txt_reading_material_title', null, ['class' => 'form-control', 'id'=>'txt_reading_material_title']) !!}
                                        </div>
                                    </div>

                                    <!-- Reference Material Url Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_reading_material_reference_material_url">Website URL Link</label>
                                        <div class="col-sm-9">
                                            {!! Form::text('txt_reading_material_reference_material_url', null, ['class' => 'form-control', 'id'=>'txt_reading_material_reference_material_url']) !!}
                                        </div>
                                    </div>

                                    <!-- Upload File Path Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_reading_material_upload_file_path">Upload File Path</label>
                                        <div class="col-sm-7">
                                            {!! Form::file('txt_reading_material_upload_file_path', ['rows'=>'4','class' => 'custom-file-input', 'id'=>'txt_reading_material_upload_file_path']) !!}
                                        </div>
                                    </div>

                                </div>
                                
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-modify-reading-material" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $('#btn-show-modify-reading-material-modal').click(function(){
        $('#modify-reading-material-error-div').hide();
        $('#modify-reading-material-modal').modal('show');
        $('#form-modify-reading-material').trigger("reset");
        $('#txt_reading_material_id').val(0);
    });

    //Show Modal for Edit Entry
    $('.btn-edit-modify-reading-material-modal').click(function(){
        $('#modify-reading-material-error-div').hide();
        $('#modify-reading-material-modal').modal('show');
        $('#form-modify-reading-material').trigger("reset");

        let itemId = $(this).attr('data-val');
        $('#txt_reading_material_id').val(itemId);

        //Set title and url
        $('#txt_reading_material_title').val($('#spn_rm_'+itemId+'_title').html());
        $('#txt_reading_material_reference_material_url').val($('#spn_rm_'+itemId+'_desc').html());

    });

    //Delete action
    $('.btn-delete-reading-material').click(function(e){
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        if (confirm("Are you sure you want to delete this reading material?")){

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
                        window.alert("The reading material has been deleted.");
                        location.reload(true);
                    }
                },
            });            
        }
        
    });

    function save_reading_material_details(fileDetails){

        let actionType = "POST";
        let endPointUrl = "{{ route('classMaterials.store') }}";
        let primaryId = $('#txt_reading_material_id').val();

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('classMaterials.update',0) }}"+primaryId;
        }

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('type', 'reading-materials');
        formData.append('title', $('#txt_reading_material_title').val());
        formData.append('course_class_id', {{ ($courseClass) ? $courseClass->id : '' }});
        if (fileDetails!=null){
            formData.append('upload_file_path', fileDetails[0]);
            formData.append('upload_file_type', fileDetails[1]);
        }
        formData.append('reference_material_url', $('#txt_reading_material_reference_material_url').val());

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

                    $('#modify-reading-material-error-div').html('');
                    $('#modify-reading-material-error-div').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#modify-reading-material-error-div').append('<li class="">'+value+'</li>');
                    });

                }else{
                    $('#modify-reading-material-error-div').hide();
                    window.setTimeout( function(){
                        window.alert("Reading material saved successfully.");
                        $('#modify-reading-material-modal').modal('hide');
                        location.reload(true);
                    }, 50);
                }
            },
        });
    }

    //Save reading material
    $('#btn-modify-reading-material').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

 
        if ($('#txt_reading_material_upload_file_path')[0].files[0] == null){
            
            save_reading_material_details(null);

        }else{

            var formData = new FormData();
            formData.append('file', $('#txt_reading_material_upload_file_path')[0].files[0]);

            $.ajax({
                url: "{{ route('attachment-upload') }}",
                type: 'POST', processData: false,
                contentType: false, data: formData,
                success: function(data){
                    console.log(data); 
                    save_reading_material_details(data.message);
                },
                error: function(data){ console.log(data); }
            });
        }
    });



});
</script>
@endsection
