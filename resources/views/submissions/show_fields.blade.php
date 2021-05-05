<!-- Title Field -->
<div id="div_submission_title" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('title', 'Title:', ['class'=>'control-label']) !!} 
        <span id="spn_submission_title">
        @if (isset($submission->title))
            {!! $submission->title !!}
        @endif
        </span>
    </p>
</div>

<!-- Upload File Path Field -->
<div id="div_submission_upload_file_path" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('upload_file_path', 'Upload File Path:', ['class'=>'control-label']) !!} 
        <span id="spn_submission_upload_file_path">
        @if (isset($submission->upload_file_path))
            {!! $submission->upload_file_path !!}
        @endif
        </span>
    </p>
</div>

