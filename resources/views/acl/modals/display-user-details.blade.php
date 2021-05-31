

<div class="modal fade" id="modify-user-details-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-user-details-title" class="modal-title">Modify User Account</h4>
            </div>

            <div class="modal-body">
                <div id="modify-user-details-error-div" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="form-modify-user-details" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
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
                                    {!! Form::select('department_id', $departmentItems, null, ['id'=>'department_id','class'=>'form-control select2']) !!}
                                </div>
                            </div>

                            <div id="div_registration_num" class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="code">Registration#</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="text"
                                            id="matric_num"
                                            name="matric_num"
                                            class="form-control @error('matric_num') is-invalid @enderror"
                                            value="{{ old('matric_num') }}"
                                            placeholder="Matriculation Number">
                                        @error('matric_num')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-10 col-sm-3" for="code">First Name</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="text"
                                            id="first_name"
                                            name="first_name"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            value="{{ old('first_name') }}"
                                            placeholder="First Name">
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
                                        <input type="text"
                                            id="last_name"
                                            name="last_name"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            value="{{ old('last_name') }}"
                                            placeholder="Last Name">
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
                                        <input type="email"
                                            id="email"
                                            name="email"
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
                                <label class="control-label mb-10 col-sm-3" for="code">Telephone #</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="number"
                                            id="telephone"
                                            name="telephone"
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
                <button type="button" class="btn btn-primary" id="btn-modify-user-details" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {
    
    $('#department_id').select2();
    $('#div_registration_num').hide();
    
    $('#sel_account_type').on('change', function() {
        $('#div_registration_num').hide();
        if (this.value == "student"){
            $('#div_registration_num').show();
        }
    });

    //Show Modal for New Entry
    $('#btn-show-modify-user-details-modal').click(function(){
        $('#modify-user-details-error-div').hide();
        $('#div_registration_num').hide();
        $('.modal-footer').show();
        $('.spinner1').hide();
        $('#modify-user-details-modal').modal('show');
        $('#form-modify-user-details').trigger("reset");
        $('#txt_user_account_id').val(0);
        $('#div_account_type').show();

        $('#modify-user-details-title').html("Create User Account");
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-modify-user-details-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        $('#txt_user_account_id').val(itemId);
        $('#div_account_type').hide();
        $('.spinner1').hide();

        $('#modify-user-details-title').html("Modify User Account");

        $.get( "{{ route('dashboard.user',0) }}"+itemId).done(function( data ) {

            $('#modify-user-details-modal').modal('show');
            $('#form-modify-user-details').trigger("reset");
            $('#div_registration_num').hide();
            $('.modal-footer').show();
            $('#modify-user-details-error-div').hide();

            if (data.student_id!=null){
                $('#div_registration_num').show();
                $('#matric_num').val(data.matric_number);
                $('#txt_student_account_id').val(data.student_id);
            } else {
                $('#div_registration_num').hide();
            }

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
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        if (confirm("Are you sure you want to disable this user account?")){

            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());

            let itemId = $(this).attr('data-val');
            let endPointUrl = "{{ route('dashboard.user-disable-account',0) }}"+itemId;

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
                        window.alert("The user account has been disabled.");
                        location.reload(true);
                    }
                },
            });
        }
    });

    //Enable Model
    $(document).on('click', ".btn-enable-user-account", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        if (confirm("Are you sure you want to enable this user account?")){

            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());

            let itemId = $(this).attr('data-val');
            let endPointUrl = "{{ route('dashboard.user-enable-account',0) }}"+itemId;

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
                        window.alert("The user account has been enabled.");
                        location.reload(true);
                    }
                },
            });
        }
    });

    //Delete action
    $(document).on('click', ".btn-delete-user-details", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        if (confirm("Are you sure you want to delete this user account?")){

            let endPointUrl = "{{ route('dashboard.user-delete-account',0) }}"+itemId;

            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            
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
                        window.alert("The user account has been deleted.");
                        location.reload(true);
                    }
                },
            });            
        }
        
    });

    //Save user details
    $('#btn-modify-user-details').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').show();
        $('#btn-modify-user-details').prop("disabled", true);
        let actionType = "POST";
        let endPointUrl = "{{ route('dashboard.user-update',0) }}";
        let primaryId = $('#txt_user_account_id').val();

        if (primaryId>0){
            actionType = "POST";
            endPointUrl = "{{ route('dashboard.user-update',0) }}"+primaryId;
            
        }

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('id', primaryId);
        formData.append('first_name', $('#first_name').val());
        formData.append('last_name', $('#last_name').val());
        formData.append('email', $('#email').val());
        formData.append('telephone', $('#telephone').val());
        formData.append('student_id', $('#txt_student_account_id').val());
        formData.append('department_id', $('#department_id').val());
        formData.append('matriculation_number', $('#matric_num').val());
        formData.append('account_type', $('#sel_account_type').val());

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

                    $('#modify-user-details-error-div').html('');
                    $('#modify-user-details-error-div').show();
                    $('.spinner1').hide();
                    $('#btn-modify-user-details').prop("disabled", false);
                    
                    $.each(result.errors, function(key, value){
                        $('#modify-user-details-error-div').append('<li class="">'+value+'</li>');
                    });

                }else{
                    $('#modify-user-details-error-div').hide();
                    $('#btn-modify-user-details').prop("disabled", false);
                    $('.spinner1').hide();
                    window.setTimeout( function(){
                        window.alert("User account saved successfully.");
                        $('#modify-user-details-modal').modal('hide');
                        location.reload(true);
                    }, 50);
                }
            },
        });
        
    });

});
</script>
@endsection
