<!-- Group Name Field -->
<div id="div_forum_group_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('group_name', 'Group Name:', ['class'=>'control-label']) !!} 
        <span id="spn_forum_group_name">
        @if (isset($forum->group_name))
            {!! $forum->group_name !!}
        @endif
        </span>
    </p>
</div>

<!-- Posting Field -->
<div id="div_forum_posting" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('posting', 'Posting:', ['class'=>'control-label']) !!} 
        <span id="spn_forum_posting">
        @if (isset($forum->posting))
            {!! $forum->posting !!}
        @endif
        </span>
    </p>
</div>

