<!-- <div class='btn-group'> -->
    <a id="btn-view-{{$id}}" href="#" alt="View Account" data-val="{{$id}}" data-toggle="modal" data-target="#view" class='pa-5 btn btn-default btn-xs btn-edit-modify-user-details-modal'>
        <i class="glyphicon glyphicon-eye-open" data-toggle="tootip" title="View user details"></i>
    </a>
    @if ($is_disabled == 0)
    <a id="btn-disable-{{$id}}" href="#" alt="Disable Account" data-val="{{$id}}" data-toggle="modal" data-target="#disable" class='pa-5 btn btn-default btn-xs btn-disable-user-account text-danger'>
        <i class="fa fa-times" data-toggle="tootip" title="Disable user account"></i>
    </a>
    @else
    <a id="btn-enable-{{$id}}" href="#" alt="Enable Account" data-val="{{$id}}" data-toggle="modal" data-target="#enable" class='pa-5 btn btn-default btn-xs btn-enable-user-account'>
        <i class="fa fa-check" data-toggle="tootip" title="Enable user account"></i>
    </a>
    @endif
    <a id="btn-reset-{{$id}}" href="#" alt="Reset Password" data-val="{{$id}}" data-toggle="modal" data-target="#reset" class='pa-5 btn btn-default btn-xs btn-edit-modify-user-password-reset-modal'>
        <i class="fa fa-key" data-toggle="Reset user password"></i>
    </a>
    <!-- <a id="btn-delete-{{$id}}" href="#" alt="Delete Account" data-val="{{$id}}" data-toggle="modal" data-target="#delete" class='pa-5 btn btn-default btn-xs btn-delete-user-details'>
        <i class="fa fa-trash"></i>
    </a> -->
<!-- </div> -->
