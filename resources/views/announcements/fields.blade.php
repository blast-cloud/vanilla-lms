<!-- Title Field -->
<div id="div-title" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="title">Title</label>
    <div class="col-sm-9">
        {!! Form::text('title', null, ['id' => 'announcement_title','class' => 'form-control']) !!}
    </div>
</div>

<!-- Description Field -->
<div id="div-description" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="description">Description</label>
    <div class="col-sm-9">
        {!! Form::textarea('description', null, ['id' => 'announcement_description','class' => 'form-control']) !!}
    </div>
</div>