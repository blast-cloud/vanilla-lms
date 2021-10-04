@if ($current_user->lecturer_id!=null)
<a href="#" id="btn-show-new-discussion-modal" class="btn btn-xs btn-primary btn-new-mdl-forum-modal">
    <i class="fa fa-upload" style=""></i> New Discussion Board
</a>
<br/>
@endif

<table class="table table-hover mb-0">
    @foreach($forums as $idx=>$forum)
    <tr>
        <td width="80px">
            <i class="fa fa-5x fa-comments"></i>
        </td>
        <td>
            <span id="spn_forum_{{$forum->id}}_title">{{ $forum->group_name }}</span> <br/>
            <span id="spn_forum_{{$forum->id}}_desc" style="font-size:80%" class="text-success">{{ $forum->posting }}</span>

            @if ($current_user->lecturer_id!=null)
            <br/>
            <a class="text-info btn-edit-mdl-forum-modal" href="#" alt="Edit Discussion Board" style="opacity:0.5;font-size:85%" data-val="{{$forum->id}}">
                <i class="fa fa-pencil" style=""></i>&nbsp;Edit
            </a> &nbsp;&nbsp;
            <!--<a class="text-info btn-delete-mdl-forum-modal" href="#"  alt="Delete Discussion Board" style="opacity:0.5;font-size:85%" data-val="{{$forum->id}}">
                <i class="fa fa-trash" style=""></i>&nbsp;Delete
            </a>-->
            @endif
            
        </td>
        <td width="80px">
            <a href="#" id="btn-show-board-{{$forum->id}}" class="btn btn-xs btn-primary btn-show-view-forum-modal" data-val="{{$forum->id}}">
                <i class="fa fa-eye" style=""></i> View
            </a>
        </td>
    </tr>
    @endforeach
</table>
<hr class="light-grey-hr mb-10 mt-0"/>


    
<div class="modal fade" id="mdl-forum-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-forum-modal-title" class="modal-title">Discussion Board</h4>
            </div>

            <div class="modal-body">
                <div id="div-forum-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-forum-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            @csrf

                            <div class="spinner1" >
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-forum-primary-id" value="0" />
                            <div id="div-edit-txt-forum-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    
                                        <!-- Group Name Field -->
                                        <div id="div-group_name" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="txt_forum_group_name">Name</label>
                                            <div class="col-sm-9">
                                                {!! Form::text('txt_forum_group_name', null, ['id'=>'txt_forum_group_name', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>

                                        <!-- Posting Field -->
                                        <div id="div-description" class="form-group">
                                            <label class="control-label mb-10 col-sm-3" for="txt_forum_description">Description</label>
                                            <div class="col-sm-9">
                                                {!! Form::textarea('txt_forum_description', null, ['id'=>'txt_forum_description', 'class' => 'form-control']) !!}
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
                <button type="button" class="btn btn-primary" id="btn-save-mdl-forum-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>


@section('js-134')
<script type="text/javascript">
$(document).ready(function() {

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-forum-modal", function(e) {
        $('#div-forum-modal-error').hide();
        $('#mdl-forum-modal').modal('show');
        $('#frm-forum-modal').trigger("reset");
        $('#txt-forum-primary-id').val(0);
        $('.spinner1').hide();

        $('#div-show-txt-forum-primary-id').hide();
        $('#div-edit-txt-forum-primary-id').show();
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-forum-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').hide();
        $('#div-show-txt-forum-primary-id').hide();
        $('#div-edit-txt-forum-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{URL::to('/')}}/api/forums/"+itemId).done(function( response ) {            
            $('#div-forum-modal-error').hide();
            $('#mdl-forum-modal').modal('show');
            $('#frm-forum-modal').trigger("reset");
            $('#txt-forum-primary-id').val(response.data.id);

            $('#txt_forum_group_name').val(response.data.group_name);
            $('#txt_forum_description').val(response.data.posting);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-forum-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        let itemId = $(this).attr('data-val');

        swal({
      title: "Are you sure you want to delete this discussion?",
      text: "This is an irriversible action!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            let actionType = "DELETE";
            let endPointUrl = "{{ route('forums.destroy',0) }}"+itemId;

            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('_method', actionType);
            
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
                        swal("Done!","The Discussion has been deleted!","success");
                        location.reload(true);
                    }
                },
            });
        }
        }); 
    });

    //Save details
    $('#btn-save-mdl-forum-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        $('.spinner1').show();
        $('#btn-save-mdl-forum-modal').prop("disabled", true);
        let actionType = "POST";
        let endPointUrl = "{{ route('forums.store') }}";
        let primaryId = $('#txt-forum-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId>0){
            actionType = "PUT";
            endPointUrl = "{{ route('forums.update',0) }}"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        formData.append('group_name', $('#txt_forum_group_name').val());
        formData.append('posting', $('#txt_forum_description').val());
        formData.append('course_class_id', {{$courseClass->id}});

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
                    $('#div-forum-modal-error').html('');
                    $('#div-forum-modal-error').show();
                    $('.spinner1').hide();
                    $('#btn-save-mdl-forum-modal').prop("disabled", false);
                    $.each(result.errors, function(key, value){
                        $('#div-forum-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-forum-modal-error').hide();
                    $('.spinner1').hide();
                    $('#btn-save-mdl-forum-modal').prop("disabled", false);
                    window.setTimeout( function(){
                        swal("Done!","Discussions saved successfully!","success");
                        $('#div-forum-modal-error').hide();
                        location.reload(true);
                    },20);
                }
            }, error: function(data){
                console.log(data);
            }
        });
    });

});
</script>
@endsection
