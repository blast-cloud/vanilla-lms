<div class="modal fade" id="modify-user-details-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 id="modify-user-details-title" class="modal-title">Modify User Account</h4>
            </div>

            <div class="modal-body">
                <div id="modify-user-details-error-div" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="form-modify-user-details" role="form" method="POST"
                    enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span id="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt_user_account_id" value="0" />
                            <input type="hidden" id="txt_student_account_id" value="0" />

                            {{-- <div id="div_user_type" class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="user_type">User Type</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <select name="user_type" id="user_type" class="form-control @error('user_type') is-invalid @enderror" >
                                            <option >Choose User Type...</option>
                                            <option value="manager">Manager</option>
                                            <option value="lecturer">Lecturer</option>
                                            <option value="student">Student</option>
                                          </select>
                                        @error('user_type')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}

                            <div id="div_account_type" class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="code">Account Type</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <select id="sel_account_type" class="form-control">
                                            <option value="">Choose Type</option>
                                            <option value="lecturer">Lecturer</option>
                                            <option value="student">Student</option>
                                            <option value="manager">Department Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Department Field -->
                            <div id="div-department_id" class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="department_id">Department</label>
                                <div class="col-sm-8">
                                    {!! Form::select('department_id', $departmentItems, null, [
                                        'id' => 'department_id',
                                        'class' => 'form-control select2',
                                    ]) !!}
                                </div>
                            </div>

                            <div id="div_registration_num" class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="code">Registration#</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="text" id="matriculation_number" name="matriculation_number"
                                            class="form-control @error('matriculation_number') is-invalid @enderror"
                                            value="{{ old('matriculation_number') }}"
                                            placeholder="Matriculation Number">
                                        @error('matriculation_number')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id='div_level'>
                                <label class="control-label mb-10 col-sm-3" for="code">Level </label>
                                <div class="col-sm-9">

                                    <div class="input-group">
                                        <select name="level" id="level" class="form-control"
                                            style="padding-right: 20px">
                                            <option value=""> -- Select level -- </option>
                                            @foreach ($levels as $item)
                                                <option value="{{ $item->level }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('level')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>


                                </div>

                            </div>
                            <div id="div-job_title" class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="job_title">Job Title</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="text" id="job_title" name="job_title"
                                            class="form-control @error('job_title') is-invalid @enderror"
                                            value="{{ old('job_title') }}" placeholder="Job Title">
                                        @error('job_title')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="code">First Name</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="text" id="first_name" name="first_name"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            value="{{ old('first_name') }}" placeholder="First Name">
                                        @error('first_name')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="code">Last Name</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="text" id="last_name" name="last_name"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            value="{{ old('last_name') }}" placeholder="Last Name">
                                        @error('last_name')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="code">Email Address</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="email" id="email" name="email"
                                            value="{{ old('email') }}"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Email">
                                        @error('email')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="code">Sex </label>
                                <div class="col-sm-9">

                                    <div class="input-group">
                                        <select name="sex" id="sex" class="form-control"
                                            style="padding-right: 20px">
                                            <option value=""> -- Select sex -- </option>
                                            <option value="Male"> Male </option>
                                            <option value="Female"> Female </option>
                                        </select>
                                        @error('sex')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>


                                </div>

                            </div>

                            <!-- Has Graduated Field -->
                            <div id="div-has_graduated" class="form-group">

                                <label class="col-sm-3 control-label mb-10">Has Graduated</label>
                                <label class="col-sm-2 checkbox-inline" style="margin-left: 20px">
                                    <input id="has_graduated" type="checkbox" value="1">
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="code">Telephone #</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="number" id="telephone" name="telephone"
                                            value="{{ old('telephone') }}"
                                            class="form-control @error('telephone') is-invalid @enderror"
                                            placeholder="Telephone Number">
                                        @error('telephone')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-modify-user-details"
                    value="add">Save</button>
            </div>

        </div>
    </div>
</div>

{{-- Bulk upload modal --}}
<div class="modal fade" id="mdl-bulk-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 id="lbl-student-modal-title" class="modal-title">Bulk Users Upload</h4>
            </div>

            <div class="modal-body">
                <div id="div-bulk-user-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-user-modal" role="form" method="POST"
                    enctype="multipart/form-data" action="">
                    <div class="row">
                        @csrf
                        <div class="col-lg-12 ma-10">
                            <div id="bulk-user-type" class="form-group">
                                <label class="control-label col-sm-3">Type of users</label>
                                <div class="col-sm-7">
                                    <select id="type" class="form-control select2">
                                        <option value="">--Choose type--</option>
                                        <option value="student">Student</option>
                                        <option value="lecturer">Lecturer</option>
                                        <option value="manager">Department Admin</option>
                                    </select>
                                </div>
                            </div>

                            <div id="departments_div" class="form-group">
                                <label class="control-label col-sm-3">Departments</label>
                                <div class="col-sm-7">
                                    <select id="department" class="form-control select2">
                                        <option value="">--Select Option--</option>
                                        @foreach($departments as $department)
                                             <option value={{$department->id}}>{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="offline-flag"><span class="no-file">Please upload a csv file</span></div>
                            <div id="spinner-user" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <div id="div-show-txt-user-primary-id" style="display: none;" class="upload-tem">
                                <div class="row">
                                    <div class="col-lg-12 ma-10">
                                        <div id="div-bulk_user" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="bulk_user">Upload
                                                CSV</label>
                                            <div class="col-sm-9">
                                                {!! Form::file('bulk_user', ['class' => 'custom-file-input', 'id' => 'bulk_user']) !!}
                                            </div>
                                        </div>
                                        <span class="badge badge-pill badge-secondary mb-5 ml-30">Users csv file
                                            format:</span>
                                        <a id="format_csv_file" src="" class="btn btn-sm btn-danger"
                                            data-toggle="tootip" title="Users csv file format"> <i
                                                class="fa fa-download"></i> Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="div-save-mdl-user-modal" class="modal-footer upload-tem" style="display: none;">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-bulk-user-modal"
                    value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#department_id').prepend('<option value="">-- select department--</option>')

            $('.no-file').hide();
            $("#spinner-user").fadeOut(1);
            $('#div-bulk-user-modal-error').hide();


            $('#div_registration_num').hide();
            $('#div_level').hide();
            $('#div-has_graduated').hide();
            $("#div-job_title").hide();
            $('#sel_account_type').on('change', function() {
                $('#div_registration_num').hide();
                if (this.value == "student") {
                    $('#div_registration_num').show();
                    $('#div_level').show();
                    $('#div-has_graduated').show();
                    $("#div-job_title").hide();
                } else{
                    $("#div-job_title").show();
                }
            });

            //Show Modal for New Entry
            $('#btn-show-modify-user-details-modal').click(function() {
                $('#modify-user-details-error-div').hide();
                $('.input-border-error').removeClass("input-border-error");
                $('#div_registration_num').hide();
                $('.modal-footer').show();
                $('.spinner1').hide();
                $('#modify-user-details-modal').modal('show');
                $('#form-modify-user-details').trigger("reset");
                $('#txt_user_account_id').val(0);
                $('#div_account_type').show();
                $('#department_id option').attr('selected', false);

                $('#modify-user-details-title').html("Create User Account");
            });

            //Show Modal for Edit
            $(document).on('click', ".btn-edit-modify-user-details-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                let itemId = $(this).attr('data-val');
                $('#txt_user_account_id').val(itemId);
                $('.input-border-error').removeClass("input-border-error");
                $('#div_account_type').show();
                $('.spinner1').hide();

                $('#modify-user-details-title').html("Modify User Account");

                $.get("{{ route('dashboard.user', 0) }}" + itemId).done(function(data) {
                    $('#department_id option').attr('selected', false);
                    $('#department_id option[value="' + data.department_id + '"]').attr('selected',
                        true);
                    $('#modify-user-details-modal').modal('show');
                    $('#form-modify-user-details').trigger("reset");
                    $('#div_registration_num').hide();
                    $('.modal-footer').show();
                    $('#modify-user-details-error-div').hide();
                    console.log(data);
                    if (data.student_id != null) {
                        $('#sel_account_type').val("student");
                        $('#div_account_type').hide();
                        $("#div-job_title").hide();
                        $('#div_registration_num').show();
                        $('#div_level').show();
                        $('#div-has_graduated').show();
                        $('#matriculation_number').val(data.student.matriculation_number);
                        $('#level').val(data.student.level);
                        $('#txt_student_account_id').val(data.student_id);
                        if(data.student.has_graduated == true){
                            $('#has_graduated').prop('checked',true);
                        }else{
                            $('#has_graduated').prop('checked',false);
                        }
                    } else {
                        $('#div_registration_num').hide();
                        $('#div_level').hide();
                        $('#div-has_graduated').hide();
                        $("#div-job_title").show();
                    }

                    if (data.manager_id) {
                        $('#sel_account_type').val("manager")
                        $('#job_title').val(data.manager.job_title);
                    }
                    if (data.lecturer_id) {
                        $('#sel_account_type').val("lecturer")
                        $('#job_title').val(data.lecturer.job_title);
                    }

                    $('#sex').val(data.sex);
                    $('#txt_user_account_id').val(data.id);
                    $('#first_name').val(data.first_name);
                    $('#last_name').val(data.last_name);
                    $('#telephone').val(data.telephone);
                    $('#email').val(data.email);

                });

            });

            //Disable Model
            $(document).on('click', ".btn-disable-user-account", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                let itemId = $(this).attr('data-val');
                $.get("{{ route('dashboard.user', 0) }}" + itemId).done(function(data) {
                    $('.spinner1').hide();
                    console.log(data);
                    let fullname_info = (data.first_name + ' ' + data.last_name);
                    let email_info = data.email;
                    swal({
                        title: "Are you sure you want to disable " + fullname_info + " ?",
                        icon: "warning",
                        text: 'EMAIL : ' + email_info,
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());

                            let endPointUrl = "{{ route('dashboard.user-disable-account', 0) }}" +
                                itemId;

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
                                        swal("Disabled!", "The user account (" + email_info + ") has been disabled!",
                                            "success");
                                        location.reload(true);
                                    }
                                },
                            });
                        }
                    });
                });
            });

            //Enable Model
            $(document).on('click', ".btn-enable-user-account", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                let itemId = $(this).attr('data-val');
                $.get("{{ route('dashboard.user', 0) }}" + itemId).done(function(data) {
                    $('.spinner1').hide();
                    console.log(data);
                    let fullname_info = (data.first_name + ' ' + data.last_name);
                    let email_info = data.email;

                    swal({
                        title: "Are you sure you want to enable " + fullname_info + " ?",
                        icon: "warning",
                        text: 'EMAIL : ' + email_info,
                        buttons: true,
                        dangerMode: false,
                    })

                    .then((willDelete) => {
                        if (willDelete) {
                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());

                            let endPointUrl = "{{ route('dashboard.user-enable-account', 0) }}" +
                                itemId;

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
                                        swal("Enabled!",
                                            fullname_info + " account has been enabled! Kindly check " + email_info + " to retrieve account details.",
                                            "success");
                                        location.reload(true);
                                    }
                                },
                            });
                        }
                    });


                });
            });

            //Delete action
            $(document).on('click', ".btn-delete-user-details", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                let itemId = $(this).attr('data-val');
                swal({
                        title: "Are you sure you want to delete this user account?",
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
                            let endPointUrl = "{{ route('dashboard.user-delete-account', 0) }}" +
                                itemId;

                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());

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
                                        swal("Done!", "The user account has been deleted!",
                                            "success");
                                        location.reload(true);
                                    }
                                },
                            });
                        }
                    });
            });

            //Save user details
            $('#btn-modify-user-details').click(function(e) {
                e.preventDefault();

                //check for internet status 
                if (!window.navigator.onLine) {
                    $('#offline').fadeIn(300);
                    return;
                } else {
                    $('#offline').fadeOut(300);
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                $('.spinner1').show();
                $('#btn-modify-user-details').prop("disabled", true);
                let actionType = "POST";
                let endPointUrl = "{{ route('dashboard.user-update', 0) }}";
                let primaryId = $('#txt_user_account_id').val();

                if (primaryId > 0) {
                    actionType = "POST";
                    endPointUrl = "{{ route('dashboard.user-update', 0) }}" + primaryId;

                }

                let formData = new FormData();
                console.log($('#sex').val());
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('_method', actionType);
                formData.append('id', primaryId);
                formData.append('job_title', $('#job_title').val());
                formData.append('first_name', $('#first_name').val());
                formData.append('last_name', $('#last_name').val());
                formData.append('email', $('#email').val());
                formData.append('telephone', $('#telephone').val());
                formData.append('student_id', $('#txt_student_account_id').val());
                formData.append('department_id', $('#department_id').val());
                formData.append('matriculation_number', $('#matriculation_number').val());
                formData.append('level', $('#level').val());
                if($('#has_graduated').is(':checked')){
                    formData.append('has_graduated', 1);
                }else{
                    formData.append('has_graduated', 0);
                }
                formData.append('sex', $('#sex').val());
                formData.append('account_type', $('#sel_account_type').val());

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

                            $('#modify-user-details-error-div').html('');
                            $('#modify-user-details-error-div').show();
                            $('.spinner1').hide();
                            $('#btn-modify-user-details').prop("disabled", false);

                            $.each(result.errors, function(key, value) {
                                $('#modify-user-details-error-div').append(
                                    '<li class="">' + value + '</li>');
                                $('#' + key).addClass("input-border-error");
                                $('#' + key).keyup(function(e) {
                                    console.log("got here");
                                    if ($('#' + key).val() != '') {
                                        $('#' + key).removeClass(
                                            "input-border-error")
                                    } else {
                                        $('#' + key).addClass(
                                            "input-border-error")
                                    }
                                });
                            });

                        } else {
                            $('#modify-user-details-error-div').hide();
                            $('#btn-modify-user-details').prop("disabled", false);
                            $('.spinner1').hide();
                            window.setTimeout(function() {
                                swal("Done!", "User account saved successfully!",
                                    "success");
                                $('#modify-user-details-modal').modal('hide');
                                location.reload(true);
                            }, 50);
                        }
                    },
                });

            });

        });

        $(document).on('change', '#type', function() {
            $('.upload-tem').fadeOut(300);
            let img_area = $('#format_csv_file');
            let type = $(this).val();

            if (type == 'student') {
                $(img_area).attr("href", "{{ asset('csv/student_user_upload_cvs_format.csv') }}");
            } else if (type == 'lecturer') {
                $(img_area).attr("href", "{{ asset('csv/lecturer_user_upload_cvs_format.csv') }}");
            } else if (type == 'manager') {
                $(img_area).attr("href", "{{ asset('csv/manager_user_upload_csv_format.csv')}}");
            } else {
                return;
            }
            $('.upload-tem').fadeIn(400);
        })

        $(document).on('click', '#btn-save-mdl-bulk-user-modal', function(e) {
            e.preventDefault();

            $('.no-file').hide();
            $("#spinner-user").show();
            $(this).attr('disabled', true);

            let formData = new FormData();
            formData.append('_method', "POST");
            endPointUrl = "{{ route('api.user.bulk') }}";
            @if (isset($organization) && $organization != null)
                formData.append('organization_id', '{{ $organization->id }}');
            @endif
            formData.append('type', $('#type').val());
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('department_id',$('#department').val());
            if ($('#bulk_user')[0].files.length > 0) {
                formData.append('bulk_user_file', $('#bulk_user')[0].files[0]);
                $.ajax({
                    url: endPointUrl,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);
                        $("#spinner-user").fadeOut(100);
                        $('#btn-save-mdl-bulk-user-modal').attr('disabled', false);
                        if (result.errors) {
                            $('#div-bulk-user-modal-error').html('');
                            $('#div-bulk-user-modal-error').show();

                            $.each(result.errors, function(key, value) {
                                $('#div-bulk-user-modal-error').append('<li class="">' + value +
                                    '</li>');
                            });
                        } else {
                            $('#div-bulk-user-modal-error').hide();
                            window.setTimeout(function() {
                                swal("Saved", "Users saved successfully.", "success");

                                $('#div-bulk-user-modal-error').hide();
                                location.reload(true);

                            }, 20);
                        }

                        $("#spinner-user").hide();
                        $("#div-save-mdl-user-modal").attr('disabled', false);

                    },
                    error: function(data) {
                        console.log(data);
                        swal("Error", "Oops an error occurred. Please try again.", "error");

                        $("#spinner-user").hide();
                        $("#btn-save-mdl-bulk-user-modal").attr('disabled', false);

                    }
                })
            } else {
                $("#spinner-user").fadeOut(100);
                $('.no-file').fadeIn();
                $("#btn-save-mdl-bulk-user-modal").attr('disabled', false);
            }

        });
    </script>
@endsection
