    
    <a href="#" data-val='{{$id}}' class='btn-show-mdl-credit-load-modal' data-toggle="tootip" title="View Credit Load details">
        {!! Form::button('<i class="fa fa-eye"></i>', ['type'=>'button']) !!}
    </a>
    
    <a href="#" data-val='{{$id}}' class='btn-edit-mdl-credit-load-modal' data-toggle="tootip" title="Edit Credit Load details">
        {!! Form::button('<i class="fa fa-edit"></i>', ['type'=>'button']) !!}
    </a>

    {{-- <a href="#" data-val='{{$id}}' class='btn-level-delete-modal' data-toggle="tootip" title="Delete level">
        {!! Form::button('<i class="fa fa-key"></i>', ['type'=>'button']) !!}
    </a>
     --}}
    <a href="#" data-val='{{$id}}' class='btn-delete-mdl-credit-load-modal' data-toggle="tootip" title="Delete Credit Load">
        {!! Form::button('<i class="fa fa-trash"></i>', ['type'=>'button']) !!}
    </a>
