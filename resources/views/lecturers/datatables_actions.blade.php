    
    <a href="#" data-val='{{$id}}' class='btn-show-mdl-lecturer-modal' data-toggle="tootip" title="View lecturer details">
        {!! Form::button('<i class="fa fa-eye"></i>', ['type'=>'button']) !!}
    </a>
    
    <a href="#" data-val='{{$id}}' class='btn-edit-mdl-lecturer-modal' data-toggle="tootip" title="View lecturer details">
        {!! Form::button('<i class="fa fa-edit"></i>', ['type'=>'button']) !!}
    </a>

    <a href="#" data-val='{{$id}}' class='btn-lecturer-password-reset-modal' data-toggle="tootip" title="Reset lecturer password">
        {!! Form::button('<i class="fa fa-key"></i>', ['type'=>'button']) !!}
    </a>

    {{-- <a href="#" alt="Reset Password" data-toggle="modal" data-target="#lecturer-password-reset-modal" class='btn btn-default btn-xs'>
        <i class="fa fa-key" data-toggle="tootip" title="Reset lecturer password"></i>
    </a> --}}