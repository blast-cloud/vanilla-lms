<center>
    <a href="#" data-val='{{$id}}' title="View Notification" class='btn-show-mdl-semester-notification-modal'>
        {!! Form::button('<i class="fa fa-eye"></i>', ['type'=>'button']) !!}
    </a>
    @if($broadcast_status == 0)
        <a href="#" data-val='{{$id}}' title="Edit Notification" class='btn-edit-mdl-semester-notification-modal'>
        {!! Form::button('<i class="fa fa-edit"></i>', ['type'=>'button']) !!}
        </a>

        <a href="#" data-val='{{$id}}' title="Delete Notification" class='btn-delete-mdl-semester-notification-modal'>
        {!! Form::button('<i class="fa fa-trash"></i>', ['type'=>'button']) !!}
        </a>

        <a href="#" data-val='{{$id}}' title="Broadcast Notification" class='btn-edit-mdl-semester-notification-modal'>
            {!! Form::button('<i class="fa fa-volume-up"></i>', ['type'=>'button']) !!}
        </a>
    @endif
</center>