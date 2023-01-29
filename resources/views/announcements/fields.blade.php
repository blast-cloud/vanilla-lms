<!-- Title Field -->
<div id="div-title" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="title">Title</label>
    <div class="col-sm-9">
        {!! Form::text('title', null, ['id' => 'announcement_title','class' => 'form-control']) !!}
    </div>
</div>

    <!-- Announcement End Date Field -->
<div class="form-group">
    <label class="control-label mb-10 col-sm-3" for="txt_announcement_end_date">End Date</label>
    <div class="col-sm-4">
        {!! Form::date('announcement_end_date', null, ['id'=>'announcement_end_date', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Description Field -->
<div id="div-description" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="description">Description</label>
    <div class="col-sm-9">
        {!! Form::textarea('description', null, ['id' => 'announcement_description','class' => 'form-control']) !!}
    </div>
</div>