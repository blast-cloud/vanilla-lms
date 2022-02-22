

<div class="modal fade" id="mdl-courseClass-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-courseClass-modal-title" class="modal-title">Course Class</h4>
            </div>

            <div class="modal-body">
                <div id="div-courseClass-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-courseClass-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-courseClass-primary-id" value="0" />
                            <div id="div-show-txt-courseClass-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('course_classes.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-courseClass-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">

                                        <!-- Course Id Field -->
                                        <div id="div-course_id" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="semester_id">Semester</label>
                                            <div class="col-sm-9">
                                                {!! Form::select('semester_id', $semesterItems, null, ['id'=>'semester_id','class'=>'form-control select2']) !!}
                                            </div>
                                        </div>

                                        <!-- Course Id Field -->
                                        <div id="div-course_id" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="course_id">Course</label>
                                            <div class="col-sm-9">
                                                {!! Form::select('course_id', $courseItems, null, ['id'=>'course_id','class'=>'form-control select2']) !!}
                                            </div>
                                        </div>

                                        <!-- Lecturer Id Field -->
                                        <div id="div-lecturer_id" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="lecturer_id">Lecturer</label>
                                            <div class="col-sm-9">
                                                {!! Form::select('lecturer_id', $lecturerItems, null, ['id'=>'lecturer_id','class'=>'form-control select2']) !!}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-courseClass-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {

    $('#course_id').select2();
    $('#lecturer_id').select2();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-courseClass-modal", function(e) {
       
        $('#course_id').prepend('<option value="" selected> Select Course  </option>');
        $('#lecturer_id').prepend('<option value="" selected> Select Lecturer</option>');
        $('#div-courseClass-modal-error').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('.spinner1').hide();
        $('.modal-footer').show();
        $('#mdl-courseClass-modal').modal('show');
        $('#frm-courseClass-modal').trigger("reset");
        $('#txt-courseClass-primary-id').val(0);

        $('#div-show-txt-courseClass-primary-id').hide();
        $('#div-edit-txt-courseClass-primary-id').show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-courseClass-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-show-txt-courseClass-primary-id').show();
        $('#div-edit-txt-courseClass-primary-id').hide();
        $('.spinner1').hide();
        $('.modal-footer').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{URL::to('/')}}/api/course_classes/"+itemId).done(function( response ) {
			$('#div-courseClass-modal-error').hide();
			$('#mdl-courseClass-modal').modal('show');
			$('#frm-courseClass-modal').trigger("reset");
			$('#txt-courseClass-primary-id').val(response.data.id);

            $('#spn_courseClass_code').html(response.data.code);
            $('#spn_courseClass_name').html(response.data.name);
            $('#spn_courseClass_credit_hours').html(response.data.credit_hours);
            $('#div_courseClass_email_address').hide();   
            $('#div_courseClass_telephone').hide();   
            $('#div_courseClass_location').hide();   
            $('#div_courseClass_next_lecture_date').hide();   
            $('#div_courseClass_next_exam_date').hide();   
            $('#div_courseClass_outline').hide();   
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-courseClass-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('.modal-footer').show();
        $('#div-show-txt-courseClass-primary-id').hide();
        $('#div-edit-txt-courseClass-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{URL::to('/')}}/api/course_classes/"+itemId).done(function( response ) {            
			$('#div-courseClass-modal-error').hide();
			$('#mdl-courseClass-modal').modal('show');
			$('#frm-courseClass-modal').trigger("reset");
			$('#txt-courseClass-primary-id').val(response.data.id);

            $('#course_id').val(response.data.course_id).trigger('change');
            $('#lecturer_id').val(response.data.lecturer_id).trigger('change');
            $('#semester_id').val(response.data.semester_id).trigger('change');
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-courseClass-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this CourseClass?",
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
            let endPointUrl = "{{ route('api.course_classes.destroy',0) }}"+itemId;

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
                        swal("Done!", "The CourseClass record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-courseClass-modal').click(function(e) {
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
        $('#btn-save-mdl-courseClass-modal').prop("disabled", true);
        let courseId = $('#course_id').val();
        $.get( "{{URL::to('/')}}/api/courses/"+courseId).done(function( response ) {

            let actionType = "POST";
            let endPointUrl = "{{ route('api.course_classes.store') }}";
            let primaryId = $('#txt-courseClass-primary-id').val();
            
            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());

            if (primaryId>0){
                actionType = "PUT";
                endPointUrl = "{{ route('api.course_classes.update',0) }}"+primaryId;
                formData.append('id', primaryId);
            }
            
            formData.append('_method', actionType);
            formData.append('code', response.data.code);
            formData.append('name', response.data.name);
            formData.append('credit_hours', response.data.credit_hours);
            formData.append('course_id', $('#course_id').val());
            formData.append('department_id', {{$department->id}});
            formData.append('lecturer_id', $('#lecturer_id').val());
            formData.append('semester_id', $('#semester_id').val());

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
                        $('#div-courseClass-modal-error').html('');
                        $('#div-courseClass-modal-error').show();
                        $('.spinner1').hide();
                        $('#btn-save-mdl-courseClass-modal').prop("disabled", false);
                        $.each(result.errors, function(key, value){
                            $('#div-courseClass-modal-error').append('<li class="">'+value+'</li>');
                            $('#'+key).addClass("input-border-error");
                           
                        });
                    }else{
                        $('#div-courseClass-modal-error').hide();
                        $('.spinner1').hide();
                        $('#btn-save-mdl-courseClass-modal').prop("disabled", false);
                        window.setTimeout( function(){
                            swal("Done!", "The CourseClass record saved successfully!", "success");
                            $('#div-courseClass-modal-error').hide();
                            location.reload(true);
                        },20);
                    }
                }, error: function(data){
                    $('.spinner1').hide();
                    $('#btn-save-mdl-courseClass-modal').prop("disabled", false);
                    $('#div-courseClass-modal-error').html('');
                    $('#div-courseClass-modal-error').show();
                    $('#div-courseClass-modal-error').append('<li class="">Semester, Course and Lecturer Field are Required</li>');
    
                }
            });

        });

    });

});
</script>
@endsection
