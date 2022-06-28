
<div class="modal fade" id="notification-semester-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-semester-modal-title" class="modal-title"> Notification Details</h4> 
            </div>

            <div class="modal-body">
                <div id="div-notification-semester-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-notification-semester-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-semester-notification-primary-id" value="0" />
                            <div id="div-show-notification-txt-semester-primary-id">
                                @include('semesters.show-notification-txt-semester')
                            </div>

                            <div id="div-edit-notification-txt-semester-primary-id">
                                @include('semesters.edit-notification-txt-semester')
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('js-139')
<script type="text/javascript">
$(document).ready(function() {
    $(document).ready(function() {
      $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });

    $('body').append('<div style="" id="loadingDiv"><div class="loader">Loading...</div></div>');
    $(window).on('load', function(){
      setTimeout(removeLoader, 1000); //wait for page load PLUS two seconds.
    });
    function removeLoader(){
        $( "#loadingDiv" ).fadeOut(500, function() {
          // fadeOut complete. Remove the loading div
          $( "#loadingDiv" ).remove(); //makes page more lightweight 
      });  
    }
});

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-semester-notification-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.modal-footer').hide();
        $('#div-show-notification-txt-semester-primary-id').show();
        $('#div-edit-notification-txt-semester-primary-id').hide();
        let itemId = $(this).attr('data-val');
        $('.spinner1').hide();

        $.get( "{{URL::to('/')}}/notifications/"+itemId).done(function( response ) {
            $('#div-notification-semester-modal-error').hide();
            $('#notification-semester-modal').modal('show');
            $('#frm-notification-semester-modal').trigger("reset");
            
            $('#txt-semester-notification-primary-id').val(response.data.id);
            $('#div-title').html('<h5>Notification Title: </h5><blockquote><article>' + response.data.title + '</article></blockquote>');
            $('#div-message').html('<h5>Notification Message: </h5><blockquote><textarea disabled style="width:100%">' + response.data.message + '</textarea></blockquote>');
            let receiversVar = "";
            if(response.data.managers_receives == '1'){ receiversVar += "All Managers<br>"; }
            if (response.data.lecturers_receives == '1') { receiversVar += "All Lecturers<br>"; }
            if (response.data.students_receives == '1') { receiversVar += "All Students<br>"; } 
            if (response.data.managers_receives == '0' && response.data.lecturers_receives == '0' && response.data.students_receives == '0') { receiversVar += " Nil<br>"; }
            $('#div-receivers').html('<h5>Broadcast for: </h5><blockquote><article>' + receiversVar + '</article></blockquote>');
        });
    });

});
</script>
@endsection
