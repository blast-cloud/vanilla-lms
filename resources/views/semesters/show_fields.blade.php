<!-- academic sessio -->
<div id="div_semester_academic_session" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('academic_session', 'Academic Session:', ['class'=>'control-label']) !!} 
        <span id="spn_semester_academic_session">
        @if (isset($semester->academic_session))
            {!! $semester->academic_session !!}
        @endif
        </span>
    </p>
</div>

<!-- Code Field -->
<div id="div_semester_code" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('code', 'Semester Code:', ['class'=>'control-label']) !!} 
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
        {!! Form::label('start_date', 'Semester Start Date:', ['class'=>'control-label']) !!} 
        <span id="spn_semester_start_date">
        @if (isset($semester->start_date))
            {!! date("D-M-Y", strtotime($semester->start_date)) !!}
        @endif
        </span>
    </p>
</div>

<!-- End Date Field -->
<div id="div_semester_end_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('end_date', 'Semester End Date:', ['class'=>'control-label']) !!} 
        <span id="spn_semester_end_date">
        @if (isset($semester->end_date))
            {!! date("D-M-Y", strtotime($semester->end_date)) !!}
        @endif
        </span>
    </p>
</div>

