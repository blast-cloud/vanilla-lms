<!-- Grade Title Field -->
<div id="div_grade_grade_title" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('grade_title', 'Grade Title:', ['class'=>'control-label']) !!} 
        <span id="spn_grade_grade_title">
        @if (isset($grade->grade_title))
            {!! $grade->grade_title !!}
        @endif
        </span>
    </p>
</div>

<!-- Score Field -->
<div id="div_grade_score" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('score', 'Score:', ['class'=>'control-label']) !!} 
        <span id="spn_grade_score">
        @if (isset($grade->score))
            {!! $grade->score !!}
        @endif
        </span>
    </p>
</div>

<!-- Grade Letter Field -->
<div id="div_grade_grade_letter" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('grade_letter', 'Grade Letter:', ['class'=>'control-label']) !!} 
        <span id="spn_grade_grade_letter">
        @if (isset($grade->grade_letter))
            {!! $grade->grade_letter !!}
        @endif
        </span>
    </p>
</div>

