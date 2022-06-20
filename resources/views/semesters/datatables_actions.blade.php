    
    {{-- <a href="#" data-val='{{$id}}' title="View Semester" class='btn-show-mdl-semester-modal'>
        {!! Form::button('<i class="fa fa-eye"></i>', ['type'=>'button']) !!}
    </a> --}}

    <a href="{{URL::to('/')}}/semesters/{{$id}}" title="View Semester" class='btn-show-mdl-semester-modal'>{!! Form::button('<i class="fa fa-eye"></i>View', ['type'=>'button']) !!}
    </a>

    <a href="#" data-val='{{$id}}' title="Edit Semester" class='btn-edit-mdl-semester-modal'>
        {!! Form::button('<i class="fa fa-edit"></i>Edit', ['type'=>'button']) !!}
    </a>
    
    {{-- <a href="#" data-val='{{$id}}' class='btn-delete-mdl-semester-modal'>
        {!! Form::button('<i class="fa fa-trash"></i>', ['type'=>'button']) !!}
    </a>
 --}}