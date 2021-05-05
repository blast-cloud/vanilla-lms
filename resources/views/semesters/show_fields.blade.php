<!-- Code Field -->
<div id="div_semester_code" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('code', 'Code:', ['class'=>'control-label']) !!} 
        <span id="spn_semester_code">
        @if (isset($semester->code))
            {!! $semester->code !!}
        @endif
        </span>
    </p>
</div>

<!-- Start Date Field -->
<div id="div_semester_start_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('start_date', 'Start Date:', ['class'=>'control-label']) !!} 
        <span id="spn_semester_start_date">
        @if (isset($semester->start_date))
            {!! $semester->start_date !!}
        @endif
        </span>
    </p>
</div>

<!-- End Date Field -->
<div id="div_semester_end_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('end_date', 'End Date:', ['class'=>'control-label']) !!} 
        <span id="spn_semester_end_date">
        @if (isset($semester->end_date))
            {!! $semester->end_date !!}
        @endif
        </span>
    </p>
</div>

