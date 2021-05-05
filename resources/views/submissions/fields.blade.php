<!-- Title Field -->
<div id="div-title" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="title">Title</label>
    <div class="col-sm-9">
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Upload File Path Field -->
<div id="div-upload_file_path" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="upload_file_path">Upload File Path</label>
    <div class="col-sm-9">
        {!! Form::file('upload_file_path', ['class' => 'custom-file-input']) !!}
    </div>
</div>

