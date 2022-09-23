<!-- FAQ Type Field -->
<div id="div-type" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="type">Type</label>
    <div class="col-sm-9">
        {!! Form::select('type', ['help'=> 'Help', 'faq'=>'FAQ'], null, ['class' => 'form-control custom-select']) !!}
    </div>
</div>

<!-- Question Field -->
<div id="div-question" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="question">Question</label>
    <div class="col-sm-9">
        {!! Form::text('question', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Answer Field -->
<div id="div-answer" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="answer">Answer</label>
    <div class="col-sm-9">
        {!! Form::textarea('answer', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Answer Field -->
<div id="div-answer" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="is_visible">Visible</label>
    <div class="col-sm-3">
        {!! Form::checkbox('is_visible', true) !!}
    </div>
</div>