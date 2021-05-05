<!-- Code Field -->
<div id="div-code" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="code">Code</label>
    <div class="col-sm-9">
        {!! Form::text('code', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Name Field -->
<div id="div-name" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="name">Name</label>
    <div class="col-sm-9">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Description Field -->
<div id="div-description" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="description">Description</label>
    <div class="col-sm-9">
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Credit Hours Field -->
<div id="div-credit_hours" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="credit_hours">Credit Hours</label>
    <div class="col-sm-3">
        {!! Form::number('credit_hours', null, ['class' => 'form-control']) !!}
    </div>
</div>