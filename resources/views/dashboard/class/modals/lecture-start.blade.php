

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
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-11 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt_lecture_id" value="0" />
                            <!-- Assignment Number Field -->
                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="txt_start_lecture_number">Lecture Number</label>
                                <div class="col-sm-2">
                                    {!! Form::number('txt_start_lecture_number', null, ['id'=>'txt_start_lecture_number','min' => '0',  'class' => 'form-control']) !!}
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
                <button type="button" class="btn btn-primary" id="btn-start-lecture" value="add">Save</button>
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
        $('.spinner1').hide();
        $('#start-lecture-modal').modal('show');
        $('#form-start-lecture').trigger("reset");
        $('#txt_lecture_id').val(0);
    });

    //Show Modal for Edit Entry
    $('.btn-edit-start-lecture-modal').click(function(e){
        $('#start-lecture-error-div').hide();
        $('.spinner1').hide();
        $('#start-lecture-modal').modal('show');
        $('#form-start-lecture').trigger("reset");

        let itemId = $(this).attr('data-val');
        $('#txt_lecture_id').val(itemId);

        //Set title and url
        $('#txt_start_lecture_description').val($('#spn_ol_'+itemId+'_desc').html());
        $('#txt_start_lecture_title').val($('#spn_ol_'+itemId+'_title').html());
        $('#txt_start_lecture_number').val($('#spn_ol_'+itemId+'_num').html());
        $('#txt_start_lecture_reference_material_url').val($('#spn_ass_'+itemId+'_url').html());
    });

    //Delete action
    $('.btn-delete-lecture').click(function(e){
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this lecture?",
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
                        swal("Done!", "The Lecture has been deleted!", "success");
                        location.reload(true);
                    }
                },
            }); 
          }
        });
    });

    function save_lecture_details(fileDetails){
        let lecture_file = $('#txt_start_lecture_upload_file_path')[0].files[0];
        if( lecture_file == undefined) {
            lecture_file = '';
        }
        $('.spinner1').show();
        $('#btn-start-lecture').prop("disabled", true);
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
        if (fileDetails!=null){
            formData.append('upload_file_path', fileDetails[0]);
            formData.append('upload_file_type', fileDetails[1]);
        }
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
                    $('.spinner1').hide();
                    $('#btn-start-lecture').prop("disabled", false);
                    
                    $.each(result.errors, function(key, value){
                        $('#start-lecture-error-div').append('<li class="">'+value+'</li>');
                    });

                }else{
                    $('#start-lecture-error-div').hide();
                    $('.spinner1').hide();
                    $('#btn-start-lecture').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!","Online lecture created, please click Start Online Blackboard to continue!","success");
                        $('#start-lecture-modal').modal('hide');
                        location.reload(true);
                    }, 1000);
                }
            },
        });

    }

    //Save assignment
    $('#btn-start-lecture').click(function(e) {
        e.preventDefault();

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline').fadeIn(300);
            return;
        }else{
            $('.offline').fadeOut(300);
        }

        $('.spinner1').show();
        $('#btn-start-lecture').prop("disabled", true);
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
       
        if ($('#txt_start_lecture_upload_file_path')[0].files[0] == null){
            
            save_lecture_details(null);
            $('.spinner1').hide();

        }else{

            var formData = new FormData();
            formData.append('file', $('#txt_start_lecture_upload_file_path')[0].files[0]);

            $.ajax({
                url: "{{ route('attachment-upload') }}",
                type: 'POST', processData: false,
                contentType: false, data: formData,
                success: function(data){
                    console.log(data); 
                    save_lecture_details(data.message);  
                },
                error: function(data){ 
                    console.log(data);
                    $('.spinner1').hide();
                    $('#btn-start-lecture').prop("disabled", false);
                }
            });
        }
    });


});
</script>
@endsection
