<!-- Title Field -->
<div id="div_announcement_title" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('title', 'Title:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_title">
        @if (isset($announcement->title))
            {!! $announcement->title !!}
        @endif
        </span>
    </p>
</div>

<!-- Description Field -->
<div id="div_announcement_description" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('description', 'Description:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_description">
        @if (isset($announcement->description))
            {!! $announcement->description !!}
        @endif
        </span>
    </p>
</div>

