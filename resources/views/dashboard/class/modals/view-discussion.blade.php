

<div class='modal fade' id='view-forum-modal' tabindex='-1' role='dialog' aria-hidden='true'>
    <div class='modal-dialog modal-xl' role='document'>
        <div class='modal-content'>

            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>
                <h4 id='view-forum-title' class='modal-title'></h4>
            </div>

            <div class='modal-body'>
                <input type="hidden" id="txt-parent-forum-id" value="0" />

                <div class='chat-cmplt-wrap chat-for-widgets-1' style='height:auto;'>

                    <div class='recent-chat-box-wrap' style='width:100%;'>
                        <div class='recent-chat-wrap'>
                            <div class='panel-wrapper collapse in'>
                                <div class='panel-body pa-0'>
                                    <div class='chat-content'>
                                        <div class='slimScrollDiv' style='position: relative; overflow: hidden; width: auto;'>                                            
                                            <ul id='forum-comment-list' class='chatapp-chat-nicescroll-bar pt-10' style='overflow: hidden; width: auto;'></ul>
                                            <div class='slimScrollBar' style='background: rgb(135, 135, 135); width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 0px; z-index: 99; right: 1px;'></div>
                                            <div class='slimScrollRail' style='width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

            <div class='modal-footer'>
                {{-- <button type='button' class='btn btn-primary' id='btn-view-forum' value='add'>Start Lecture</button> --}}
                <div class='col-sm-12'>
                    <div class='input-group mb-15'>
                        <span class='input-group-addon'><i class='img-circle img-sm fa fa-comments-o' style='font-size:25px;padding-top:2px;'></i></span>
                        <input id='comment-text' type='text' class='form-control input-sm' placeholder='Type in your comments and press enter to save comments'>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@section('js-133')
<script type='text/javascript'>
$(document).ready(function() {

    //Show Modal
    $('.btn-show-view-forum-modal').click(function(e){

        let itemId = $(this).attr('data-val');
        $('#view-forum-title').html($('#spn_forum_'+itemId+'_title').html());
        $('#txt-parent-forum-id').val(itemId);
        $('#forum-comment-list').empty();        

        $('#view-forum-modal').modal('show');
        load_comment_list(itemId);
    });

    function load_comment_list(itemId){
        $.get( "{{URL::to('/')}}/api/forums?parent_forum_id="+itemId).done(function( response ) {
            if (response && response.data){
                $('#forum-comment-list').empty();
                response.data.forEach(function (item){
                    if ( item.posting_user_id != "{{$current_user->id}}" ){
                        commentItem = "<li class='friend mb-5'><div class='friend-msg-wrap'>";
                        commentItem += "<img class='user-img img-circle block pull-left' src='{{ asset('dist/img/user-badge.fw.png') }}' alt='user'><div class='msg pull-left'>";
                        commentItem += "<p>" + item.posting + "</p>";
                        commentItem += "<div class='msg-per-detail text-right'><span class='msg-time txt-grey'>" +  new Intl.DateTimeFormat('en-GB', { dateStyle: 'long', timeStyle: 'short' }).format(Date.parse(item.created_at));
                        commentItem += "</span></div></div><div class='clearfix'></div></div></li>";
                    }else{
                        commentItem = "<li class='self mb-5'><div class='self-msg-wrap'><div class='msg block pull-right'>" + item.posting;
                        commentItem += "<div class='msg-per-detail text-right'><span class='msg-time txt-grey'>" +  new Intl.DateTimeFormat('en-GB', { dateStyle: 'long', timeStyle: 'short' }).format(Date.parse(item.created_at));
                        commentItem += "</span></div></div><div class='clearfix'></div></div></li>";
                    }
                    $('#forum-comment-list').append(commentItem);
                });
            }
        });
    }

    //Delete action
    $('.btn-delete-forum-entry').click(function(e){
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $("input[name='_token']").val()}});

        let itemId = $(this).attr('data-val');
        swal({
          title: "Are you sure you want to delete this posting?",
          text: "This is an irriversible action!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            let actionType = 'DELETE';
            let endPointUrl = "{{ route('classMaterials.destroy',0) }}"+itemId;

            let formData = new FormData();
            formData.append('_token', $("input[name='_token']").val());
            formData.append('_method', actionType);
            
            $.ajax({
                url:endPointUrl,
                type: 'POST',
                data: formData,
                cache: false,
                processData:false,
                contentType: false,
                dataType: 'json',
                success: function(result){
                    if(result.errors){
                        console.log(result.errors)
                    }else{
                        swal("Done!","The Posting has been deleted!","success");
                        location.reload(true);
                    }
                },
            });
          }
        }); 
    });
    
    $("#comment-text").on('keypress', function(e){
        itemId = $('#txt-parent-forum-id').val();

        if (e.which==13 && $('#comment-text').val().length > 2){
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
            e.preventDefault();

            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('posting',$('#comment-text').val());
            formData.append('parent_forum_id', $('#txt-parent-forum-id').val());
            formData.append('course_class_id', {{$courseClass->id}});
            formData.append('group_name', $('#spn_forum_'+itemId+'_title').html());
            formData.append('posting_user_id', {{$current_user->id}});
            @if ($current_user->student_id != null)
                formData.append('student_id', {{$current_user->student_id}});
            @endif

            $.ajax({
                url: "{{ route('forums.store') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(data){
                    load_comment_list($('#txt-parent-forum-id').val());
                    $('#comment-text').val("");
                },
                error: function(data){
                    console.log(data);
                }
            });
        }
    });


});
</script>
@endsection
