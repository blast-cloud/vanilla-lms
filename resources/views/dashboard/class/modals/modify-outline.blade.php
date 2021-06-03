

<div class="modal fade" id="modify-outline-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-outline-title" class="modal-title">Course Outline & Outcomes</h4>
            </div>

            <div class="modal-body">
                <div id="modify-outline-error-div" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="form-modify-outline" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>
                                                        
                            <div class="form-wrap">
                                
                                <div class="col-sm-12">

                                    <!-- Description Field -->
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            {!! Form::textarea('txt_outline_description', null, ['id'=>'txt_outline_description','rows'=>'15','class' => 'form-control']) !!}
                                        </div>
                                    </div>


                                </div>
                                
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-modify-outline" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@section('js-116')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal
    $('#btn-show-modify-outline-modal').click(function(){
        $('#modify-outline-error-div').hide();
        $('#modify-outline-modal').modal('show');
        $('.spinner1').hide();
        $('#txt_outline_description').val($('#spn_class_outline').html());
    });

    //Save lecturer
    $('#btn-modify-outline').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').show();
        $('#btn-modify-outline').prop("disabled", true);
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', 'PUT');
        formData.append('id', {{ ($courseClass) ?  $courseClass->id : ''}});
        formData.append('outline', $('#txt_outline_description').val());

        let artifact_url = "{{ route('dashboard.course-class-outline', ($courseClass) ? $courseClass->id : '') }}";
        $.ajax({
            url:artifact_url,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(result){
                if(result.errors){

                    $('#modify-outline-error-div').html('');
                    $('#modify-outline-error-div').show();
                    $('.spinner1').hide();
                    $('#btn-modify-outline').prop("disabled", false);
                    $.each(result.errors, function(key, value){
                        $('#modify-outline-error-div').append('<li class="">'+value+'</li>');
                    });

                }else{
                    $('#modify-outline-error-div').hide();
                    $('.spinner1').hide();
                    $('#btn-modify-outline').prop("disabled", false);
                    window.setTimeout( function(){
                        window.alert("Class outline saved successfully.");
                        $('#modify-outline-modal').modal('hide');
                        location.reload(true);
                    }, 500);
                }
            },
        }); 
    });

});
</script>
@endsection
