

<div class='modal fade' id='view-forum-modal' tabindex='-1' role='dialog' aria-hidden='true'>
    <div class='modal-dialog modal-xl' role='document'>
        <div class='modal-content'>

            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>
                <h4 id='view-forum-title' class='modal-title'></h4>
            </div>

            <div class='modal-body'>
                <input type="hidden" id="txt-parent-forum-id" value="0" />
                <div id="spinner1" class="spinner1">
                    <div class="loader" id="loader-1"></div>
                </div>
                <div class="col-sm-12">
                    <div class='chat-cmplt-wrap chat-for-widgets-1' style='height:auto;'>
                    
                        <div class='recent-chat-wrap'>
                            <div class='panel-wrapper collapse in'>
                                 <div class='panel-body pa-0'>
                                    <div class='chat-content'>
                                        <div class='slimScrollDiv' style='position: relative; overflow: hidden; width: auto; height: auto;'>                                            
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

<div class="modal fade" id="modify-forum-comment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="modify-forum-comment-title" class="modal-title">Edit Post</h4>
            </div>

            <div class="modal-body">
                <div id="modify-forum-comment-error-div" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="form-modify-forum-comment" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                        <div class="col-lg-11 ma-10">
                            @csrf
                            
                            <div class="form-wrap">
                                
                                <div class="col-sm-12">
                                    <div id="spinner" class="spinner">
                                        <div class="loader" id="loader-1"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="comment_id" value="0">
                                        <input type="hidden" name="parent_id" value="0">
                                        <label class="control-label mb-10 col-sm-2" for="txt_update_comment">Comment</label>
                                        <div class="col-sm-9">
                                            {!! Form::text('txt_update_comment', null, ['id'=>'txt_update_comment','class' => 'form-control']) !!}
                                        </div> 
                                    </div>

                                </div>
                                
                            </div>                            


                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-modify-forum-comment" value="add">update</button>
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
        $.get( "{{URL::to('/')}}/api/forums/comments/"+itemId).done(function( response ) {
            
            if (response && response.data){
                $('#forum-comment-list').empty();
                let today = new Date();
                let date = today.getFullYear()+'-'+today.getMonth()+1+'-'+today.getDate();
                let time = today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();
                current_date = date+' '+time;
                $.each(response.data, function(key, item){
                    let posting_date = new Date(item.created_at)
                    let diff = (today.getTime() - posting_date.getTime())/1000;
                    diff /=(60 * 60);
                    diffHrs = Math.abs(Math.round(diff));       
                    if ( item.posting_user_id != "{{$current_user->id}}" ){
                        commentItem = "<li class='friend mb-5'><div class='friend-msg-wrap'>";
                        commentItem += "<img class='user-img img-circle block pull-left' src='{{ asset('dist/img/user-badge.fw.png') }}' alt='user'><div class='msg pull-left'>";
                        if(item.posting_user.lecturer){
                            commentItem += "<p><strong>"+ item.posting_user.lecturer.job_title+" "+ item.posting_user.lecturer.first_name+" "+ item.posting_user.lecturer.last_name +"</strong></p>";
                        }
                        if(item.posting_user.student){
                            //console.log(item.posting_user.first_name);
                            commentItem += "<p><strong>"+ item.posting_user.student.first_name+" "+ item.posting_user.student.last_name +"</strong></p>";
                        }     
                        commentItem += "<p id='comment_"+item.id+"'>"+ item.posting +"</p>";
                        commentItem += "<div class='msg-per-detail text-right'><span class='msg-time txt-grey'>" +  new Intl.DateTimeFormat('en-GB', { dateStyle: 'long', timeStyle: 'short' }).format(Date.parse(item.created_at));
                        commentItem += "</span>";
                        commentItem += "</div></div><div class='clearfix'></div></div></li>";
                    }else{

                        commentItem = "<li class='self mb-5'><div class='self-msg-wrap'><div class='msg block pull-right'>";
                        if(item.posting_user.lecturer){
                            commentItem += "<p><strong>"+ item.posting_user.lecturer.job_title+" "+ item.posting_user.lecturer.first_name+" "+ item.posting_user.lecturer.last_name +"</strong></p>";
                        }
                        if(item.posting_user.student){
                            //console.log(item.posting_user.first_name);
                            commentItem += "<p><strong>"+ item.posting_user.student.first_name+" "+ item.posting_user.student.last_name +"</strong></p>";
                        }           
                        commentItem += "<p id='comment_"+item.id+"'>"+ item.posting +"</p>";
                        commentItem += "<div class='msg-per-detail text-right'><span class='msg-time txt-grey'>" +  new Intl.DateTimeFormat('en-GB', { dateStyle: 'long', timeStyle: 'short' }).format(Date.parse(item.created_at));
                        commentItem += "</span>";
                        if(item.posting_user_id == "{{$current_user->id}}" && diffHrs <= 1){
                            commentItem += "<a href='#' class='btn-edit-modify-forum-comment-modal' data-val='"+item.id+"' parent-id='"+item.parent_forum_id+"'><i class='text-info fa fa-pencil ml-5' style='font-size:80%;opacity:0.5;'></i></a>";
                        }
                        commentItem += "</div></div><div class='clearfix'></div></div></li>";
                    }
                    $('#forum-comment-list').append(commentItem);
                });
                $('.spinner1').hide();
                setTimeOutEventListener();
            }
        });
    }

    function setTimeOutEventListener(){
        setTimeout(function(){

            $(".btn-edit-modify-forum-comment-modal").click(function(e){
                let id = $(this).attr('data-val');
                $('input[name=comment_id]').val(id);
                $('input[name=parent_id]').val($(this).attr('parent-id'));
                $('#txt_update_comment').val($('#comment_'+id).html());
                $('#modify-forum-comment-error-div').hide();
                $('.input-border-error').addClass("input-border-error");
                $('.spinner1').hide();
                $('.spinner').hide();
                $('#modify-forum-comment-modal').modal('show');
                $('#form-modify-forum-comment-modal').trigger("reset");
            });

        }, 1000);
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
            $('.spinner1').hide();
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
                        $('.spinner1').hide();
                    }else{
                        $('.spinner1').hide();
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
           
            $('.spinner1').show();
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
                    $('.spinner1').hide();
                    $('#comment-text').val("");
                },
                error: function(data){
                    console.log(data);
                    $('.spinner1').hide();
                }
            });
        }
    });

   

     //Save lecturer
    $('#btn-modify-forum-comment').click(function(e) {

        e.preventDefault();
        $('.spinner').show();
        let itemId = $("input[name='comment_id']").val();
        let parentId = $("input[name='parent_id']").val();
         
         //check for internet status 
        if (!window.navigator.onLine) {
             $('.offline').fadeIn(300);
                return;
        }else{
            $('.offline').fadeOut(300);
        }
      

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('_method', 'PUT');
           
            formData.append('posting',$('#txt_update_comment').val());
            formData.append('id',itemId);
            
            let artifact_url = "{{ route('api.forums.update','')}}/"+itemId
            $.ajax({
                url:artifact_url,
                type: "POST",
                data: formData,
                cache: false,
                processData:false,
                contentType: false,
                dataType: 'json',
                success: function(result){
                    console.log(result)
                    if(result.errors){
                        $('.spinner').hide();
                        $('#modify-class-detail-error-div').html('');
                        $('#modify-class-detail-error-div').show();
                        
                        $.each(result.errors, function(key, value){
                            $('#modify-class-detail-error-div').append('<li class="">'+value+'</li>');
                            $('#txt_class_'+key).addClass("input-border-error");
                        });
                    }else{
                        $('.spinner').hide();
                        $('#modify-class-detail-error-div').hide();
                        window.setTimeout( function(){
                            swal("Done!","Comment Updated successfully!","success");
                            $('#modify-forum-comment-modal').modal('hide');
                            load_comment_list(parentId);
                          
                        }, 500);
                }
            },
        }); 
    });

});



</script>
@endsection
