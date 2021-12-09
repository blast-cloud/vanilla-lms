<!-- <div class='btn-group'> -->
    <a id="btn-view-{{$id}}" href="#" alt="View Account" data-val="{{$id}}" data-toggle="modal" data-target="#view" class='pa-5 btn btn-default btn-xs btn-edit-modify-user-details-modal' data-toggle="tooltip" data-placement="top" title="Edit user account">
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    @if ($is_disabled == 0)
    <a id="btn-disable-{{$id}}" href="#" alt="Disable Account" data-val="{{$id}}" data-toggle="modal" data-target="#disable" class='pa-5 btn btn-default btn-xs btn-disable-user-account text-danger' data-toggle="tooltip" data-placement="top" title="Disable user account">
        <i class="fa fa-times"></i>
    </a>
    @else
    <a id="btn-enable-{{$id}}" href="#" alt="Enable Account" data-val="{{$id}}" data-toggle="modal" data-target="#enable" class='pa-5 btn btn-default btn-xs btn-enable-user-account' data-toggle="tooltip" data-placement="top" title="Enable user account">
        <i class="fa fa-check"></i>
    </a>
    @endif
    <a id="btn-reset-{{$id}}" href="#" alt="Reset Password" data-val="{{$id}}" data-toggle="modal" data-target="#reset" class='pa-5 btn btn-default btn-xs btn-edit-modify-user-password-reset-modal' data-user-type='user'>
        <i class="fa fa-key" data-toggle="Reset user password"></i>
    </a>
    <!-- <a id="btn-delete-{{$id}}" href="#" alt="Delete Account" data-val="{{$id}}" data-toggle="modal" data-target="#delete" class='pa-5 btn btn-default btn-xs btn-delete-user-details'>
        <i class="fa fa-trash"></i>
    </a> -->
<!-- </div> -->
