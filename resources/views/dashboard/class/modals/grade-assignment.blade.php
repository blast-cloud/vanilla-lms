

<div class="modal fade" id="submit-assignment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-assignment-title" class="modal-title">Submit Assignment</h4>
            </div>

            <div class="modal-body">
                <div id="submit-assignment-error-div" class="alert alert-danger" role="alert"></div>

                <div id="submit-assignment-info-div" class="alert alert-info" role="alert">
                    You have already Graded This Student, submitting another Another grade over-ride the earlier created Grade.
                </div>

                <form class="form-horizontal" id="form-modify-assignment" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-12 ma-10">
                            @csrf
                            <input id="txt_id_submission" type="hidden" value="0" />
                            <input id="txt_id_student" type="hidden" value="0" />
                            <input id="txt_id_course_class" type="hidden" value="0" />
                            <input id="txt_id_class_material" type="hidden" value="0" />
                            <input id="txt_id_grade" type="hidden" value="0" />
                            <div class="form-wrap">
                                
                                <div class="col-sm-12">

                                    
                                    <div id="spinner1" class="">
                                        <div class="loader" id="loader-1"></div>
                                      </div>
  

                                      <!-- Student Grade -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="grade_title">Grade Title</label>
                                        <div class="col-sm-7">
                                            <input name="grade_title" id="grade_title" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Student Grade -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="score">Score</label>
                                        <div class="col-sm-7">
                                            <input name="score" id="score" type="number" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Student Grade -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-3" for="grade_letter">Grade Letter</label>
                                        <div class="col-sm-5">
                                            <select name="grade_letter" id="grade_letter" class="form-control">
                                                <option value="">Chooses A Grade Letter</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="F">F</option>

                                              </select>
                                        </div>
                                    </div>



                                </div>
                                
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-submit-grade" value="add">Click to Submit Grade</button>
            </div>

        </div>
    </div>
</div>

@section('js-114')
<script type="text/javascript">
$(document).ready(function() {



    //Show Modal
    $('.btn-assignment-grade').click(function(){
        $('#spinner1').hide();
        $('#submit-assignment-info-div').hide();
        $('#submit-assignment-error-div').hide();
        $('#submit-assignment-modal').modal('show');
        $('#form-modify-assignment').trigger("reset");

        let itemId = $(this).attr('data-val-submission-id');
        $('#txt_id_submission').val(itemId);

        let courseClassId = $(this).attr('data-val-course-class-id');
        $('#txt_id_course_class').val(courseClassId);

        let studentId = $(this).attr('data-val-student-id');
        $('#txt_id_student').val(studentId);

        let classMaterialId = $(this).attr('data-val-class-material-id');
        $('#txt_id_class_material').val(classMaterialId);

        let grade_id = $(this).attr('data-val-grade-id');
        $('#txt_id_grade').val(grade_id);

        let grade_title = $(this).attr('data-val-grade-title');
        $('#grade_title').val(grade_title);

        let score = $(this).attr('data-val-score');
        $('#score').val(score);

        let grade_letter = $(this).attr('data-val-grade-letter');
        $('#grade_letter').val(grade_letter);

   

        if (grade_id > 0){
            $('#submit-assignment-info-div').show();
        }
    });


    //Save Grade
    $('#btn-submit-grade').click(function(e) {
        e.preventDefault();

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline').fadeIn(300);
            return;
        }else{
            $('.offline').fadeOut(300);
        }

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('#spinner1').show();
        $(this).prop("disabled", true);
        let actionType = "POST";
        let endPointUrl = "{{ route('grades.store') }}";
        let primaryId = $('#txt_id_grade').val();

        if (primaryId>0){
            $('#submit-assignment-info-div').show();
            actionType = "PUT";
            endPointUrl = "{{ route('grades.update',0) }}"+primaryId;
        }

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('course_class_id', $('#txt_id_course_class').val());
        formData.append('student_id', $('#txt_id_student').val());
        formData.append('class_material_id', $('#txt_id_class_material').val());
        formData.append('submission_id', $('#txt_id_submission').val());
        formData.append('grade_title', $('#grade_title').val());
        formData.append('score', $('#score').val());
        formData.append('grade_letter', $('#grade_letter').val());
        formData.append('id', primaryId );

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
                    $('#spinner1').hide();
                    $('#btn-submit-grade').prop("disabled", false);
                    $('#submit-assignment-error-div').html('');
                    $('#submit-assignment-error-div').show();
                    $.each(result.errors, function(key, value){
                        $('#submit-assignment-error-div').append('<li class="">'+value+'</li>');
                    });

                }else{
                    $('#submit-assignment-error-div').hide();
                    $('#spinner1').hide();
                    $('#btn-submit-grade').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!", "Grades saved successfully!", "success");
                        $('#submit-assignment-modal').modal('hide');
                        location.reload(true);
                    }, 50);
                }
            },
        });


       
    });



});
</script>
@endsection
