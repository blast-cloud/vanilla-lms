

<div class="modal fade" id="mdl-enrollment-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-enrollment-modal-title" class="modal-title">Enrollment</h4>
                @if(isset($current_semester))
                    @if(!empty($current_semester))
                        <small style="color: green;"><strong>CURRENT SEMESTER:</strong> {{$current_semester->code}}, {{$current_semester->academic_session}} Academic Session</small><br>
                        <small style="color: #FF0000;"><strong>NOTE:</strong> Student will be enrolled in for the current semester</i></small>
                    @endif
                @else
                    <small style="color: #FF0000;"><strong>NOTE:</strong> No Semester is actively approved by Administrator, therefore no student can be enrolled.</i></small>
                @endif
            </div>

            <div class="modal-body">
                <div id="div-enrollment-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-enrollment-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf
                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-enrollment-primary-id" value="0" />
                            <div id="div-show-txt-enrollment-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('enrollments.show_fields')
                                    </div>
                                </div>
                            </div>
                           
                            <div id="div-edit-txt-enrollment-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                        <div class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="course_id">Department</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="department_id" name="department_id" 
                                                @if(!isset($current_semester))
                                                    disabled 
                                                @endif
                                                >
                                                    <option value="">-- select department --</option>
                                                    @foreach ($departmentItems as $item)
                                                        <option value="{{$item->id}}">{{$item->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Course Id Field -->
                                        <div id="div-course_id" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="course_id">Course Class</label>
                                            <div class="col-sm-9">
                                                {{-- {!! Form::select('course_id', $courseItems, null, ['id'=>'course_id','class'=>'form-control select2']) !!} --}}
                                                <select class="form-control select2" id="course_id" name="course_id">     
                                                    <option value=""> --select course class--</option>
                                                </select>
                                             
                                               
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
                <button type="button" class="btn btn-primary" id="btn-save-mdl-enrollment-modal" value="add">Enroll</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="mdl-unenrollment-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-enrollment-modal-title" class="modal-title">Student Widthrawal</h4>
            </div>

            <div class="modal-body">
                {{-- <div id="div-enrollment-modal-error" class="alert alert-danger" role="alert"></div> --}}
                <form class="form-horizontal" id="frm-unenrollment-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf
                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <div id="div-edit-txt-unenrollment-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    
                                        <!-- Course Id Field -->
                                        <div id="div-course_id" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="course_id">Course class</label>
                                            <div class="col-sm-9">
                                                {{-- {!! Form::select('course_id', $courseItems, null, ['id'=>'course_id','class'=>'form-control select2']) !!} --}}
                                                <select class="form-control select2" id="unenroll_course_id" name="course_id">
                                                    <option value="">--Select class to widthraw student--</option>
                                                    @foreach ( $student->enrollments as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->courseclass->name }} - {{ $item->courseclass->code }}
                                                        </option>
                                                    @endforeach

                                                </select><span style="color: red; display: none;">Please select a course class</span>
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
                <button type="button" class="btn btn-primary" id="btn-save-mdl-unenrollment-modal" value="add">Widthraw</button>
            </div>

        </div>
    </div>
</div>

@section('js-113')
<script type="text/javascript">
$(document).ready(function() {
$('.spinner1').fadeOut(1);
$('.no-student').fadeOut(1);
$('#course_id').select2();  
});

    $(document).on('change', "#department_id", function(e) {
       let endPointUrl = "{{route('api.department.semester.course')}}" ;  
       let formData = new FormData();
       formData.append('semester_id',{{optional($current_semester)->id}});
       formData.append('department_id',$('#department_id').val());
        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(response){
                console.log(response);
                $('#course_id').empty();
                $('#course_id').append('<option value=""> -- select course class -- </option>')
                if(response.data.length > 0){
                    $.each(response.data,function(k,v){
                        $('#course_id').append('<option value="'+v.id+'">'+ v.code+ " :: " + v.name + " taught by " + v.lecturer.job_title +" " +v.lecturer.first_name + '</option>' );
                    });
                   
                }
            }, 
            error: function(data){
                    conole.log(data);
            }
        });
    });
         //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-enrollment-modal", function(e) {
        $('.input-border-error').removeClass("input-border-error");
        $('#div-enrollment-modal-error').hide();
        $('#mdl-enrollment-modal').modal('show');
        $('#frm-enrollment-modal').trigger("reset");
        $('#txt-enrollment-primary-id').val(0);
        $('.spinner1').hide();
        let current_semester = "{{optional($current_semester)->id}}";
        if (current_semester) {
            $('#btn-save-mdl-enrollment-modal').show();
        } else {
            $('#btn-save-mdl-enrollment-modal').hide();
        }
        $('#div-show-txt-enrollment-primary-id').hide();
        $('#div-edit-txt-enrollment-primary-id').show();

    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-enrollment-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').show();
        $('#div-show-txt-enrollment-primary-id').show();
        $('#div-edit-txt-enrollment-primary-id').hide();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/enrollments/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/enrollments/"+itemId).done(function( response ) {
			$('#div-enrollment-modal-error').hide();
            $('#btn-save-mdl-enrollment-modal').hide();
            console.log(response);
			$('#mdl-enrollment-modal').modal('show');
			$('#frm-enrollment-modal').trigger("reset");
			$('#txt-enrollment-primary-id').val(response.data.id);
            $('#spn_enrollment_course_class').html(response.data.course_class.code+" "+response.data.course_class.name);
            $('#spn_enrollment_student_name').html(response.data.student.first_name+" "+response.data.student.last_name);
            $('#spn_enrollment_matriculation_number').html(response.data.student.matriculation_number);
            // $('#spn_enrollment_').html(response.data.);
            // $('#spn_enrollment_').html(response.data.);   
        });
        $('.spinner1').hide();
       
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-enrollment-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').hide();
        $('.input-border-error').removeClass("input-border-error");
        $('#div-show-txt-enrollment-primary-id').hide();
        $('#div-edit-txt-enrollment-primary-id').show();
        let itemId = $(this).attr('data-val');

        // $.get( "{{URL::to('/')}}/api/enrollments/"+itemId).done(function( data ) {
        $.get( "{{URL::to('/')}}/api/enrollments/"+itemId).done(function( response ) {     
            console.log(response);  
            conpsole.log(itemId) ;    
			$('#div-enrollment-modal-error').hide();
			$('#mdl-enrollment-modal').modal('show');
			$('#frm-enrollment-modal').trigger("reset");
			$('#txt-enrollment-primary-id').val(response.data.id);

            // $('#').val(response.data.);
            // $('#').val(response.data.);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-enrollment-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this Enrollment?",
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
            let endPointUrl = "{{ route('enrollments.destroy',0) }}"+itemId;

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
                        swal("Done!", "The Enrollment record has been deleted!", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
    });

    //Save details
    $('#btn-save-mdl-enrollment-modal').click(function(e) {
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
        let actionType = "POST";
        let endPointUrl = "{{ route('enrollments.store') }}";
        let primaryId = $('#txt-enrollment-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('enrollments.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }
        console.log( {{ optional($current_semester)->id}});
        formData.append('_method', actionType);
        formData.append('course_class_id', $('#course_id').val());
        formData.append('student_id', {{$student->id}} );
        formData.append('department_id', $('#department_id').val() );
        formData.append('semester_id', {{ optional($current_semester)->id}} );

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
					$('#div-enrollment-modal-error').html('');
					$('#div-enrollment-modal-error').show();
                    $('.spinner1').hide();
                    $.each(result.errors, function(key, value){
                        $('#div-enrollment-modal-error').append('<li class="">'+value+'</li>');
                        $('#'+key).addClass("input-border-error");
                    });
                }else{
                    $('#div-enrollment-modal-error').hide();
                    $('.spinner1').hide();
                    window.setTimeout( function(){
                        swal("Done!", "The Enrollment record saved successfully!", "success");
                        // window.alert("The Enrollment record saved successfully.");
						$('#div-enrollment-modal-error').hide();
                        location.reload(true);
                    },20);
                }
            }, error: function(data){
                $('#div-enrollment-modal-error').html('');
                $('#div-enrollment-modal-error').show();
                $('.spinner1').hide();
                
            }
        });
    });



$(document).on('click', '#btn-save-mdl-unenrollment-modal', function (e) {
    e.preventDefault();
    $('#unenroll_course_id').next('span').fadeOut(100);
    
    let itemId = $('#unenroll_course_id').val();
    if (!itemId || itemId == '') {
        $('#unenroll_course_id').next('span').fadeIn(100);
        return;
    }
    swal({
          title: "Are you sure you want to unenroll this student from this class?",
          text: "You can still enroll this student",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $('.spinner1').fadeIn(100);
            let endPointUrl = "{{ route('enrollments.destroy',0) }}"+itemId;

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
                    $('.spinner1').fadeOut(100);
                    if(result.errors){
                        console.log(result.errors)
                    }else{
                        swal("Done!", "The student has successfully been withdrawn", "success");
                        location.reload(true);
                    }
                },
            });
          }
        });
})
</script>
@endsection
