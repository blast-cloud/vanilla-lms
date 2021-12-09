    
    <a href="#" data-val='{{$id}}' class='btn-show-mdl-student-modal' data-toggle="tootip" title="View student details">
        {!! Form::button('<i class="fa fa-eye"></i>', ['type'=>'button']) !!}
    </a>
    
    <a href="#" data-val='{{$id}}' class='btn-edit-mdl-student-modal' data-toggle="tootip" title="Edit student details">
        {!! Form::button('<i class="fa fa-edit"></i>', ['type'=>'button']) !!}
    </a>

    <a href="#" data-val='{{$id}}' class='btn-student-password-reset-modal' data-toggle="tootip" title="Reset student password">
        {!! Form::button('<i class="fa fa-key"></i>', ['type'=>'button']) !!}
    </a>
    
    {{-- <a href="#" data-val='{{$id}}' class='btn-delete-mdl-student-modal'>
        {!! Form::button('<i class="fa fa-trash"></i>', ['type'=>'button']) !!}
    </a> --}}
