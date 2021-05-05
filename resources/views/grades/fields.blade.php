<!-- Grade Title Field -->
<div id="div-grade_title" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="grade_title">Grade Title</label>
    <div class="col-sm-9">
        {!! Form::text('grade_title', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Score Field -->
<div id="div-score" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="score">Score</label>
    <div class="col-sm-3">
        {!! Form::number('score', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Grade Letter Field -->
<div id="div-grade_letter" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="grade_letter">Grade Letter</label>
    <div class="col-sm-9">
        {!! Form::text('grade_letter', null, ['class' => 'form-control']) !!}
    </div>
</div>