    
    <a href="#" data-val='{{$id}}' class='btn-show-mdl-faculty-modal' data-toggle="tootip" title="View faculty details">
        {!! Form::button('<i class="fa fa-eye"></i>', ['type'=>'button']) !!}
    </a>
    
    <a href="#" data-val='{{$id}}' class='btn-edit-mdl-faculty-modal' data-toggle="tootip" title="Edit faculty details">
        {!! Form::button('<i class="fa fa-edit"></i>', ['type'=>'button']) !!}
    </a>
    
    <a href="{{ route('faculty.departments', [$id]) }}"
        class="{{ Request::is('faculties*') ? 'active' : '' }}" data-val='{{$id}}' class='btn-add-mdl-department-modal' data-toggle="tooltip" title="Add and View Department">
        {!! Form::button('<i class="fa fa-plus"></i>', ['type'=>'button']) !!}
    </a>
