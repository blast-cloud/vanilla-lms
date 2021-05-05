<!-- Group Name Field -->
<div id="div-group_name" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="group_name">Group Name</label>
    <div class="col-sm-9">
        {!! Form::text('group_name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Posting Field -->
<div id="div-posting" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="posting">Posting</label>
    <div class="col-sm-9">
        {!! Form::textarea('posting', null, ['class' => 'form-control']) !!}
    </div>
</div>