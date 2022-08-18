<div class="modal fade" id="mdl-courseClass-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 id="lbl-courseClass-modal-title" class="modal-title">Course Class</h4>
            </div>
            <div class="modal-body">
                <div id="div-courseClass-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-courseClass-modal" role="form" method="POST"
                    enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1">
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

                                        <!-- Level Field -->
                                        <div id="div-level" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="level">Level</label>
                                            <div class="col-sm-9">
                                                <select name="level" id="level" class="form-control">
                                                    <option value="">
                                                        -- Select level --
                                                    </option>
                                                    @foreach ($levels as $item)
                                                        <option value="{{ $item->level }}">
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Course Id Field -->
                                        <div id="div-course_id" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="course_id">Course</label>
                                            <div class="col-sm-9">
                                                <select name="course_id" id="course_id">
                                                    <option value="">
                                                        -- Select Course
                                                    </option>
                                                </select>
                                                {{-- {!! Form::select('course_id', $courseItems, null, ['id'=>'course_id','class'=>'form-control select2']) !!} --}}

                                            </div>
                                        </div>

                                        <!-- Lecturer Id Field -->
                                        <div id="div-lecturer_id" class="form-group">
                                            <label class="control-label mb-10 col-sm-3"
                                                for="lecturer_id">Lecturer</label>
                                            <div class="col-sm-9">
                                                {!! Form::select('lecturer_id', $lecturerItems, null, [
                                                    'id' => 'lecturer_id',
                                                    'class' => 'form-control select2',
                                                ]) !!}
                                            </div>
                                        </div>


                                        <div id="div-class_dates" class="form-group">
                                            <div>
                                                <label class="col-sm-3 control-label mb-10 ">Class dates</label>
                                                <div class="col-sm-9 mb-10">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-md-2 col-sm-2  control-label text-left">Monday</label>
                                                        <div class="col-sm-2 col-md-1 checkbox-inline">
                                                            <input id="monday_checkbox" type="checkbox" value="1">
                                                        </div>
                                                        <label
                                                            class="col-md-1 col-sm-2 control-label text-left">Time</label>
                                                        <div class="col-sm-5 inline-block">
                                                            <input type="time" class="form-control"
                                                                name="monday_time" id="monday_time">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            class="col-md-2 col-sm-2  control-label text-left">Tuesday</label>
                                                        <div class="col-sm-2 col-md-1 checkbox-inline">
                                                            <input id="tuesday_checkbox" type="checkbox" value="1">
                                                        </div>
                                                        <label
                                                            class="col-md-1 col-sm-2 control-label text-left">Time</label>
                                                        <div class="col-sm-5 inline-block">
                                                            <input type="time" class="form-control"
                                                                name="tuesday_time" id="tuesday_time">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            class="col-md-2 col-sm-2  control-label text-left">Wednesday</label>
                                                        <div class="col-sm-2 col-md-1 checkbox-inline">
                                                            <input id="wednesday_checkbox" type="checkbox" value="1">
                                                        </div>
                                                        <label
                                                            class="col-md-1 col-sm-2 control-label text-left">Time</label>
                                                        <div class="col-sm-5 inline-block">
                                                            <input type="time" class="form-control"
                                                                name="wednesday_time" id="wednesday_time">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            class="col-md-2 col-sm-2  control-label text-left">Thursday</label>
                                                        <div class="col-sm-2 col-md-1 checkbox-inline">
                                                            <input id="thursday_checkbox" type="checkbox" value="1">
                                                        </div>
                                                        <label
                                                            class="col-md-1 col-sm-2 control-label text-left">Time</label>
                                                        <div class="col-sm-5 inline-block">
                                                            <input type="time" class="form-control"
                                                                name="thursday_time" id="thursday_time">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            class="col-md-2 col-sm-2  control-label text-left">Friday</label>
                                                        <div class="col-sm-2 col-md-1 checkbox-inline">
                                                            <input id="friday_checkbox" type="checkbox" value="1">
                                                        </div>
                                                        <label
                                                            class="col-md-1 col-sm-2 control-label text-left">Time</label>
                                                        <div class="col-sm-5 inline-block">
                                                            <input type="time" class="form-control"
                                                                name="friday_time" id="friday_time">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            class="col-md-2 col-sm-2  control-label text-left">Saturday</label>
                                                        <div class="col-sm-2 col-md-1 checkbox-inline">
                                                            <input id="saturday_checkbox" type="checkbox" value="1">
                                                        </div>
                                                        <label
                                                            class="col-md-1 col-sm-2 control-label text-left">Time</label>
                                                        <div class="col-sm-5 inline-block">
                                                            <input type="time" class="form-control"
                                                                name="saturday_time" id="saturday_time">
                                                        </div>
                                                    </div>
                                                   
                                                </div>
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
                <button type="button" class="btn btn-primary" id="btn-save-mdl-courseClass-modal"
                    value="add">Save</button>
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

            $(document).on('change', "#level", function(e) {
                let level = $('#level').val();
                console.log(level);
                $('#course_id').empty();
                $.get("{{ URL::to('/') }}/api/courses?level=" + level).done(function(response) {
                    $('#course_id').append('<option value=""> -- Select Course -- </option>')
                    if (response.data && response.data.length > 0) {
                        $.each(response.data, function(k, v) {
                            $('#course_id').append("<option value=" + v.id + ">" + v.code +
                                " - " + v.name + "</option>");
                        })

                    }
                });
            });

            //Show Modal for View
            $(document).on('click', ".btn-show-mdl-courseClass-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                $('#div-show-txt-courseClass-primary-id').show();
                $('#div-edit-txt-courseClass-primary-id').hide();
                $('.spinner1').hide();
                $('.modal-footer').hide();
                let itemId = $(this).attr('data-val');

                $.get("{{ URL::to('/') }}/api/course_classes/" + itemId).done(function(response) {
                    $('#div-courseClass-modal-error').hide();
                    $('#mdl-courseClass-modal').modal('show');
                    $('#frm-courseClass-modal').trigger("reset");
                    $('#txt-courseClass-primary-id').val(response.data.id);

                    $('#spn_courseClass_code').html(response.data.code);
                    $('#spn_courseClass_name').html(response.data.name);
                    $('#spn_courseClass_credit_hours').html(response.data.credit_hours);
                    $('#spn_courseClass_level').html(response.data.level);
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                $('.spinner1').hide();
                $('.input-border-error').removeClass("input-border-error");
                $('.modal-footer').show();
                $('#div-show-txt-courseClass-primary-id').hide();
                $('#div-edit-txt-courseClass-primary-id').show();
                let itemId = $(this).attr('data-val');

                $.get("{{ URL::to('/') }}/api/course_classes/" + itemId).done(function(response) {
                    $('#div-courseClass-modal-error').hide();
                    $('#mdl-courseClass-modal').modal('show');
                    $('#frm-courseClass-modal').trigger("reset");
                    $('#txt-courseClass-primary-id').val(response.data.id);
                    $('#course_id').val(response.data.course_id).trigger('change');
                    $('#lecturer_id').val(response.data.lecturer_id).trigger('change');
                    $('#level').val(response.data.level).trigger('change');
                    if(response.data.monday_time != null){
                        $('#monday_checkbox').prop('checked', true)
                        $('#monday_time').val(response.data.monday_time)
                    }else{
                        $('#monday_checkbox').prop('checked', false)
                        $('#monday_time').val('');
                    }

                    if(response.data.tuesday_time != null){
                        $('#tuesday_checkbox').prop('checked', true)
                        $('#tuesday_time').val(response.data.tuesday_time)
                    }else{
                        $('#tuesday_checkbox').prop('checked', false)
                        $('#tuesday_time').val('');
                    }

                    if(response.data.wednesday_time != null){
                        $('#wednesday_checkbox').prop('checked', true)
                        $('#wednesday_time').val(response.data.wednesday_time)
                    }else{
                        $('#wednesday_checkbox').prop('checked', false)
                        $('#wednesday_time').val('');
                    }

                    if(response.data.thursday_time != null){
                        $('#thursday_checkbox').prop('checked', true)
                        $('#thursday_time').val(response.data.thursday_time)
                    }else{
                        $('#thursday_checkbox').prop('checked', false)
                        $('#thursday_time').val('');
                    }

                    if(response.data.friday_time != null){
                        $('#friday_checkbox').prop('checked', true)
                        $('#friday_time').val(response.data.friday_time)
                    }else{
                        $('#friday_checkbox').prop('checked', false)
                        $('#friday_time').val('');
                    }

                    if(response.data.saturday_time != null){
                        $('#saturday_checkbox').prop('checked', true)
                        $('#saturday_time').val(response.data.saturday_time)
                    }else{
                        $('#saturday_checkbox').prop('checked', false)
                        $('#saturday_time').val('');
                    }
                    /*  $('#semester_id').val(response.data.semester_id).trigger('change'); */
                });
            });

            //Delete action
            $(document).on('click', ".btn-delete-mdl-courseClass-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

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
                            let endPointUrl = "{{ route('api.course_classes.destroy', 0) }}" + itemId;

                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());
                            formData.append('_method', 'DELETE');

                            $.ajax({
                                url: endPointUrl,
                                type: "POST",
                                data: formData,
                                cache: false,
                                processData: false,
                                contentType: false,
                                dataType: 'json',
                                success: function(result) {
                                    if (result.errors) {
                                        console.log(result.errors)
                                    } else {
                                        swal("Done!",
                                            "The CourseClass record has been deleted!",
                                            "success");
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
                } else {
                    $('.offline').fadeOut(300);
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                $('.spinner1').show();
                $('#btn-save-mdl-courseClass-modal').prop("disabled", true);
                let courseId = $('#course_id').val();
                $.get("{{ URL::to('/') }}/api/courses/" + courseId).done(function(response) {

                    let actionType = "POST";
                    let endPointUrl = "{{ route('api.course_classes.store') }}";
                    let primaryId = $('#txt-courseClass-primary-id').val();

                    let formData = new FormData();
                    formData.append('_token', $('input[name="_token"]').val());

                    if (primaryId > 0) {
                        actionType = "PUT";
                        endPointUrl = "{{ route('api.course_classes.update', 0) }}" + primaryId;
                        formData.append('id', primaryId);
                    }
                    if($('#monday_checkbox').is(':checked')){
                       
                        formData.append('monday_time', $('#monday_time').val())
                    }else{
                        formData.append('monday_time', null)
                    }


                    if($('#tuesday_checkbox').is(':checked')){
                        formData.append('tuesday_time', $('#tuesday_time').val())
                    }else{
                        formData.append('tuesday_time', null)
                    }
                    
                    if($('#wednesday_checkbox').is(':checked')){
                        formData.append('wednesday_time', $('#wednesday_time').val())
                    }else{
                        formData.append('wednesday_time', null)
                    }

                    if($('#thursday_checkbox').is(':checked')){
                        formData.append('thursday_time', $('#thursday_time').val())
                    }else{
                        formData.append('thursday_time', null)
                    }

                    if($('#friday_checkbox').is(':checked')){
                        formData.append('friday_time', $('#friday_time').val())
                    }else{
                        formData.append('friday_time', null)
                    }

                    if($('#saturday_checkbox').is(':checked')){
                        formData.append('saturday_time', $('#saturday_time').val())
                    }else{
                        formData.append('saturday_time', null)
                    }

                    formData.append('_method', actionType);
                    formData.append('code', response.data.code);
                    formData.append('name', response.data.name);
                    formData.append('level', response.data.level);
                    formData.append('credit_hours', response.data.credit_hours);
                    formData.append('course_id', $('#course_id').val());
                    formData.append('department_id', " {{ $department->id }}");
                    formData.append('lecturer_id', $('#lecturer_id').val());
                    formData.append('semester_id', "{{ optional($current_semester)->id }}");

                    $.ajax({
                        url: endPointUrl,
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(result) {
                            if (result.errors) {
                                $('#div-courseClass-modal-error').html('');
                                $('#div-courseClass-modal-error').show();
                                $('.spinner1').hide();
                                $('#btn-save-mdl-courseClass-modal').prop("disabled",
                                    false);
                                $.each(result.errors, function(key, value) {
                                    $('#div-courseClass-modal-error').append(
                                        '<li class="">' + value + '</li>');
                                    $('#' + key).addClass("input-border-error");
                                    $('#' + key).keyup(function(e) {
                                        if ($('#' + key).val() != '') {
                                            $('#' + key).removeClass(
                                                "input-border-error"
                                            )
                                        } else {
                                            $('#' + key).addClass(
                                                "input-border-error"
                                            )
                                        }
                                    });
                                });
                            } else {
                                $('#div-courseClass-modal-error').hide();
                                $('.spinner1').hide();
                                $('#btn-save-mdl-courseClass-modal').prop("disabled",
                                    false);
                                window.setTimeout(function() {
                                    swal("Done!",
                                        "The CourseClass record saved successfully!",
                                        "success");
                                    $('#div-courseClass-modal-error').hide();
                                    location.reload(true);
                                }, 20);
                            }
                        },
                        error: function(data) {
                            $('.spinner1').hide();
                            $('#btn-save-mdl-courseClass-modal').prop("disabled",
                                false);
                            $('#div-courseClass-modal-error').html('');
                            $('#div-courseClass-modal-error').show();
                            $('#div-courseClass-modal-error').append(
                                '<li class="">Semester, Course and Lecturer Field are Required</li>'
                            );

                        }
                    });

                });

            });

        });
    </script>
@endsection
