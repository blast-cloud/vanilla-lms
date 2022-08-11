<!-- Name Field -->
<div id="div-name" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="email">Name</label>
    <div class="col-sm-9">
        {!! Form::text('name', null, ['class' => 'form-control','id' => 'level_name']) !!}
    </div>
</div>

<!-- Name Field -->
<div id="div-level" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="level">Level</label>
    <div class="col-sm-9">
        {!! Form::number('level', null, ['class' => 'form-control','id' => 'level_level']) !!}
    </div>
</div>
