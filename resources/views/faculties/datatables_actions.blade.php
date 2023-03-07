    @php
    $condition = "";
    if(config('lmsfaculty.faculty',true)) {
        $condition = "Faculty";
    }elseif(config('lmsfaculty.school',true)) {
        $condition = "School";
    }elseif(config('lmsfaculty.college',true)) {
        $condition = "College";
    }else{
        $condition = "Faculty";
    }
    @endphp
    <a href="#" data-val='{{$id}}' class='btn-show-mdl-faculty-modal' data-toggle="tootip" title="View {{$condition}} Details">
        {!! Form::button('<i class="fa fa-eye"></i>', ['type'=>'button']) !!}
    </a>
    
    <a href="#" data-val='{{$id}}' class='btn-edit-mdl-faculty-modal' data-toggle="tootip" title="Edit {{$condition}} Details">
        {!! Form::button('<i class="fa fa-edit"></i>', ['type'=>'button']) !!}
    </a>

   {{--  <a href="#" data-val='{{$id}}' class='btn-delete-mdl-faculty-modal' data-toggle="tootip" title="Delete faculty details">
        {!! Form::button('<i class="fa fa-trash"></i>', ['type'=>'button']) !!}
    </a>
     --}}
    <a href="{{ route('faculty.departments', [$id]) }}"
        class="{{ Request::is('faculties*') ? 'active' : '' }}" data-val='{{$id}}' class='btn-add-mdl-department-modal' data-toggle="tooltip" title="Add {{$condition}} Departments">
        {!! Form::button('<i class="fa fa-plus"></i>', ['type'=>'button']) !!}
    </a>
