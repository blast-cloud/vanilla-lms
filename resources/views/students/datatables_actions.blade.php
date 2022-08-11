    
    <a href="#" data-val='{{$id}}' class='btn-show-mdl-student-modal' data-toggle="tootip" title="View student details">
        {!! Form::button('<i class="fa fa-eye"></i>', ['type'=>'button']) !!}
    </a>
    
    <a href="#" data-val='{{$id}}' class='btn-edit-mdl-student-modal' data-toggle="tootip" title="Edit student details">
        {!! Form::button('<i class="fa fa-edit"></i>', ['type'=>'button']) !!}
    </a>

    <a href="#" data-val='{{$id}}' class='btn-student-password-reset-modal' data-toggle="tootip" title="Reset student password">
        {!! Form::button('<i class="fa fa-key"></i>', ['type'=>'button']) !!}
    </a>
    @if ($has_graduated)
   
    <a href="#" data-val='{{$id}}' class='btn-student-re-enrollment-modal' data-toggle="tootip" title="Re-enroll student">
        {!! Form::button('<i class="fa fa-graduation-cap"></i>', ['type'=>'button']) !!}
    </a>
    @endif
  
