<!-- Title Field -->
<div id="div-title" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="title">Title</label>
    <div class="col-sm-9">
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Description Field -->
<div id="div-description" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="description">Description</label>
    <div class="col-sm-9">
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Lecture Number Field -->
<div id="div-lecture_number" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="lecture_number">Lecture Number</label>
    <div class="col-sm-3">
        {!! Form::number('lecture_number', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Assignment Number Field -->
<div id="div-assignment_number" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="assignment_number">Assignment Number</label>
    <div class="col-sm-3">
        {!! Form::number('assignment_number', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Upload File Path Field -->
<div id="div-upload_file_path" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="upload_file_path">Upload File Path</label>
    <div class="col-sm-9">
        {!! Form::file('upload_file_path', ['class' => 'custom-file-input']) !!}
    </div>
</div>



<!-- Upload File Type Field -->
<div id="div-upload_file_type" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="upload_file_type">Upload File Type</label>
    <div class="col-sm-9">
        {!! Form::text('upload_file_type', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Reference Material Url Field -->
<div id="div-reference_material_url" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="reference_material_url">Reference Material Url</label>
    <div class="col-sm-9">
        {!! Form::text('reference_material_url', null, ['class' => 'form-control']) !!}
    </div>
</div>