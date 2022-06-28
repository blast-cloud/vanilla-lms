<center>
    @if(auth()->user()->student_id != null || auth()->user()->manager_id != null || auth()->user()->lecturer_id != null)
        <a href="#" data-val='{{$id}}' title="View Notification" class='btn-show-mdl-semester-notification-modal'>
        {!! Form::button('<i class="fa fa-eye"></i> View', ['type'=>'button']) !!}
        </a>    
    @endif
    @if($broadcast_status == 0 && auth()->user()->is_platform_admin == 1)
        <a href="#" data-val='{{$id}}' title="View Notification" class='btn-show-mdl-semester-notification-modal'>
        {!! Form::button('<i class="fa fa-eye"></i>', ['type'=>'button']) !!}
        </a>
        <a href="#" data-val='{{$id}}' title="Edit Notification" class='btn-edit-mdl-semester-notification-modal'>
        {!! Form::button('<i class="fa fa-edit"></i>', ['type'=>'button']) !!}
        </a>

        <a href="#" data-val='{{$id}}' title="Delete Notification" class='btn-delete-mdl-semester-notification-modal'>
        {!! Form::button('<i class="fa fa-trash"></i>', ['type'=>'button']) !!}
        </a>
        <!-- <a href="#" data-val='{{$id}}' title="Broadcast Notification" class='btn-broadcast-mdl-semester-notification-modal'>
            {!! Form::button('<i class="fa fa-volume-up"></i>', ['type'=>'button']) !!}
        </a> -->
    @elseif(auth()->user()->is_platform_admin == 1)
        <a href="#" data-val='{{$id}}' title="View Notification" class='btn-show-mdl-semester-notification-modal'>
        {!! Form::button('<i class="fa fa-eye"></i> View', ['type'=>'button']) !!}
        </a>
    @endif
</center>