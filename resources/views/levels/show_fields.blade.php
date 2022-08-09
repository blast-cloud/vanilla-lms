<!-- Email Field -->
<div id="div_level_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('name', 'Name:', ['class'=>'control-label']) !!} 
        <span id="spn_level_name">
        @if (isset($level->name))
            {!! $level->name !!}
        @endif
        </span>
    </p>
</div>


<!-- Code Field -->
<div id="div_level_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('code', 'Code:', ['class'=>'control-label']) !!} 
        <span id="spn_level_code">
        @if (isset($level->level))
            {!! $level->level !!}
        @endif
        </span>
    </p>
</div>

