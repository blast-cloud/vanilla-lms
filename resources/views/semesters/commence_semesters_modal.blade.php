
<div class="modal fade" id="commence-semester-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-semester-modal-title" class="modal-title">Commence a new Semester</h4>
                <i><small class="" style="color:red;">NOTE: Commencing a semester automatically ends any current semester.</small></i>
            </div>

            <div class="modal-body">
                <div id="div-commence-semester-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-commence-semester-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>
                            <div id="div-commence-txt-semester-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    <!-- hidden date value  -->
                                        <input type="hidden" id="get_end_date" name="get_end_date" value="">
                                    <!-- Semester to commece -->
                                        <div id="div-code" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="is_current">Semester to Commence</label>
                                            <div class="col-sm-9">
                                                <select class = "form-control" name="is_current" id="is_current">
                                                    <option value="">None selected</option>
                                                    @if($allSemesters != null)
                                                        @foreach($allSemesters as $semester)
                                                            <option value="{{ $semester->id }}"> {{ $semester->code }} {{ $semester->academic_session }} </option>
                                                        @endforeach
                                                    @endif  
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
                <button type="button" class="btn btn-primary" id="btn-save-commence-mdl-semester-modal" value="make_current">Get Started</button>
            </div>

        </div>
    </div>
</div>

@section('js-139')
<script type="text/javascript">
$(document).ready(function() {
    $(document).on('change', "#is_current", function(e) {
        e.preventDefault();
        $('.spinner1').show();

        let selectedVal = $('#is_current').val();
        if (selectedVal != null && selectedVal != "") {
            $('.spinner1').hide();
            $('.modal-footer').show();     
        } else {
            $('#get_end_date').val('');
            $('.spinner1').hide();
            $('.modal-footer').hide();
        }
    });

    //Show Modal for Commence Semester
    $(document).on('click', ".btn-commence-a-semester-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.input-border-error').removeClass("input-border-error");
        $('#div-commence-txt-semester-primary-id').show();
        $('.modal-footer').hide();
        $('.spinner1').hide();
                    
		$('#div-commence-semester-modal-error').hide();
		$('#commence-semester-modal').modal('show');
		$('#frm-commence-semester-modal').trigger("reset");
    });

    //Save details commence semester
    $('#btn-save-commence-mdl-semester-modal').click(function(e) {
        //alert('i am clicked');
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').show();
        $('#btn-save-commence-mdl-semester-modal').prop("disabled", true);
        
  swal({
      title: "Are you sure?",
      text: "Please confirm that a new semester is about to commence, are you sartisfied with this action?",
      icon: "warning",
      buttons: [
        'No, cancel it!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        let actionType = "PUT";
        let endPointUrl = "{{ route('semesters.setcurrentsemester', ) }}";
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('_method', actionType);
        formData.append('is_current', $('#is_current').val());
        formData.append('get_end_date', $('#get_end_date').val());

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
                    $('#div-commence-semester-modal-error').html('');
                    $('#div-commence-semester-modal-error').show();
                    $('.spinner1').hide();
                    $('#btn-save-commence-mdl-semester-modal').prop("disabled", false);
                    
                    $.each(result.errors, function(key, value){
                        $('#div-commence-semester-modal-error').append('<li class="">'+value+'</li>');
                        $('#'+key).addClass("input-border-error");

                        $('#'+key).keyup(function(e) {
                            console.log("got here");
                            if($('#'+key).val() != ''){
                                $('#'+key).removeClass("input-border-error")
                            }else{
                                $('#'+key).addClass("input-border-error")
                            }
                        });
                    });
                }else{
                    $('.spinner1').hide();
                    $('#btn-save-commence-mdl-semester-modal').prop("disabled", false);
                    $('#div-commence-semester-modal-error').hide();
                    window.setTimeout( function(){
                        swal("Completed!", "New semester has been commenced successfully!", "success");
                        $('#div-commence-semester-modal-error').hide();
                        location.reload(true);
                    },28);
                }
            }, error: function(data){
                $('.spinner1').hide();
                $('#btn-save-commence-mdl-semester-modal').prop("disabled", false);
                console.log(data);
            }
        });

      } else {
        swal("Cancelled", "Current semester remains unchanged!", "error");
        $('.spinner1').hide();
        $('#btn-save-commence-mdl-semester-modal').prop("disabled", false);
        //location.reload(true);
      }
    })

    });

});
</script>
@endsection
