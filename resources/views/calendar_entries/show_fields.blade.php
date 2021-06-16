<!-- Title Field -->
<div id="div_calendarEntry_title" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('title', 'Title:', ['class'=>'control-label']) !!} 
        <span id="spn_calendarEntry_title">
        @if (isset($calendarEntry->title))
            {!! $calendarEntry->title !!}
        @endif
        </span>
    </p>
</div>

<!-- Due Date Field -->
<div id="div_calendarEntry_due_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('due_date', 'Due Date:', ['class'=>'control-label']) !!} 
        <span id="spn_calendarEntry_due_date">
        @if (isset($calendarEntry->due_date))
            {!! $calendarEntry->due_date->format('d-M-Y') !!}
        @endif
        </span>
    </p>
</div>

<!-- Description Field -->
<div id="div_calendarEntry_description" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('description', 'Description:', ['class'=>'control-label']) !!} 
        <span id="spn_calendarEntry_description">
        @if (isset($calendarEntry->description))
            {!! $calendarEntry->description !!}
        @endif
        </span>
    </p>
</div>

