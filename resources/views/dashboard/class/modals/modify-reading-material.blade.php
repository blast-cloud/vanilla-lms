

<div class="modal fade" id="modify-reading-material-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-reading-material-title" class="modal-title"><span id="class-action"></span> Reading Materials</h4>
            </div>

            <div class="modal-body">
                <div id="modify-reading-material-error-div" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="form-modify-reading-material" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt_reading_material_id" value="0" />
                            <input type="hidden" id="current_user" value="{{ $current_user->id }}">
                                                        
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

                                    <!-- Description Field -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="txt_reading_material_upload_file_path">Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="5" id="txt_reading_material_description"></textarea>
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

    // get active tab
    let curr_user_id = $('#current_user').val();
    $(document).on('click', 'a[data-toggle="tab"]', function(e) {
        sessionStorage.setItem('activeTab_'+curr_user_id, $(e.target).attr('href'));
    });
    let activeTab = sessionStorage.getItem('activeTab_'+curr_user_id);
    if(activeTab){
        $('#myTabs_6 a[href="' + activeTab + '"]').tab('show');
    }

    //Show Modal for New Entry
    $('#btn-show-modify-reading-material-modal').click(function(){
        $('#class-action').text("Add");
        $('.input-border-error').removeClass("input-border-error");
        $('#modify-reading-material-error-div').hide();
        $('#modify-reading-material-modal').modal('show');
        $('#form-modify-reading-material').trigger("reset");
        $('#txt_reading_material_id').val(0);
        $('.spinner1').hide();
    });

    //Show Modal for Edit Entry
    $('.btn-edit-modify-reading-material-modal').click(function(){
        $('#class-action').text("Modify");
        $('.input-border-error').removeClass("input-border-error");
        $('#modify-reading-material-error-div').hide();
        $('.spinner1').hide();
        $('#modify-reading-material-modal').modal('show');
        $('#form-modify-reading-material').trigger("reset");

        let itemId = $(this).attr('data-val');
        $('#txt_reading_material_id').val(itemId);

        //Set title and url
        $('#txt_reading_material_title').val($('#spn_rm_'+itemId+'_title').html());
        $('#txt_reading_material_description').val($('#spn_rm_'+itemId+'_desc').html());
       // console.log($('#spn_rm_'+itemId+'_url').child('span'));
       $('#txt_reading_material_reference_material_url').val($('#spn_rm_'+itemId+'_url').html());

    });

    //Delete action
    $('.btn-delete-reading-material').click(function(e){
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');

        swal({
          title: "Are you sure you want to delete this reading material?",
          text: "This is an irriversible action!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
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
                        swal("Done!","The reading material has been deleted!","success");
                        location.reload(true);
                    }
                },
            });
          } 
        });
    });

    function save_reading_material_details(fileDetails){
        let reading_file = $('#txt_reading_material_upload_file_path')[0].files[0];
        if( reading_file == undefined) {
            reading_file = '';
        }
        $('.spinner1').show();
        let actionType = "POST";
        let endPointUrl = "{{ route('classMaterials.store') }}";
        let primaryId = $('#txt_reading_material_id').val();

        let formData = new FormData();
        
        if (primaryId>0){
            actionType = "PUT";
            formData.append('id', primaryId);
            endPointUrl = "{{ route('classMaterials.update',0) }}"+primaryId;
        }

        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('type', 'reading-materials');
        formData.append('file', reading_file);
        formData.append('title', $('#txt_reading_material_title').val());
        formData.append('description', $('#txt_reading_material_description').val());
        formData.append('course_class_id', {{ ($courseClass) ? $courseClass->id : '' }});
        if (fileDetails!=null){
            formData.append('upload_file_path', fileDetails[0]);
            formData.append('upload_file_type', fileDetails[1]);
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

                    $('#modify-reading-material-error-div').html('');
                    $('#modify-reading-material-error-div').show();
                    $('.spinner1').hide();
                    $.each(result.errors, function(key, value){
                        $('#modify-reading-material-error-div').append('<li class="">'+value+'</li>');
                        $('#txt_reading_material_'+key).addClass("input-border-error");
                    });

                }else{
                    $('#modify-reading-material-error-div').hide();
                    $('.spinner1').hide();
                    window.setTimeout( function(){
                        swal("Done!","Reading material saved successfully!","success");
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
