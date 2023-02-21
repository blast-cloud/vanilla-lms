<!-- Semester Field -->
<div id="div_semester_code" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('semester_code', 'Semester:', ['class'=>'control-label']) !!} 
        <span id="spn_semester_code">
        @if (isset($semesterMaxCreditLoad->semester_code))
            {!! $semesterMaxCreditLoad->semester_code !!}
        @endif
        </span>
    </p>
</div>


<!-- Level Field -->
<div id="div_level" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('level', 'Level:', ['class'=>'control-label']) !!} 
        <span id="spn_level">
        @if (isset($semesterMaxCreditLoad->level))
            {!! $semesterMaxCreditLoad->level !!}
        @endif
        </span>
    </p>
</div>

<!-- Max Credit Load Field -->
<div id="div_max_credit_load" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('max_credit_load', 'Max Credit Load:', ['class'=>'control-label']) !!} 
        <span id="spn_max_credit_load">
        @if (isset($semesterMaxCreditLoad->max_credit_load))
            {!! $semesterMaxCreditLoad->max_credit_load !!}
        @endif
        </span>
    </p>
</div>

