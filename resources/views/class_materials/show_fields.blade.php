<!-- Type Field -->
<div id="div_classMaterial_type" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('type', 'Type:', ['class'=>'control-label']) !!} 
        <span id="spn_classMaterial_type">
        @if (isset($classMaterial->type))
            {!! $classMaterial->type !!}
        @endif
        </span>
    </p>
</div>

<!-- Title Field -->
<div id="div_classMaterial_title" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('title', 'Title:', ['class'=>'control-label']) !!} 
        <span id="spn_classMaterial_title">
        @if (isset($classMaterial->title))
            {!! $classMaterial->title !!}
        @endif
        </span>
    </p>
</div>

<!-- Description Field -->
<div id="div_classMaterial_description" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('description', 'Description:', ['class'=>'control-label']) !!} 
        <span id="spn_classMaterial_description">
        @if (isset($classMaterial->description))
            {!! $classMaterial->description !!}
        @endif
        </span>
    </p>
</div>

<!-- Lecture Number Field -->
<div id="div_classMaterial_lecture_number" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('lecture_number', 'Lecture Number:', ['class'=>'control-label']) !!} 
        <span id="spn_classMaterial_lecture_number">
        @if (isset($classMaterial->lecture_number))
            {!! $classMaterial->lecture_number !!}
        @endif
        </span>
    </p>
</div>

<!-- Assignment Number Field -->
<div id="div_classMaterial_assignment_number" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('assignment_number', 'Assignment Number:', ['class'=>'control-label']) !!} 
        <span id="spn_classMaterial_assignment_number">
        @if (isset($classMaterial->assignment_number))
            {!! $classMaterial->assignment_number !!}
        @endif
        </span>
    </p>
</div>

<!-- Due Date Field -->
<div id="div_classMaterial_due_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('due_date', 'Due Date:', ['class'=>'control-label']) !!} 
        <span id="spn_classMaterial_due_date">
        @if (isset($classMaterial->due_date))
            {!! $classMaterial->due_date !!}
        @endif
        </span>
    </p>
</div>

<!-- Upload File Path Field -->
<div id="div_classMaterial_upload_file_path" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('upload_file_path', 'Upload File Path:', ['class'=>'control-label']) !!} 
        <span id="spn_classMaterial_upload_file_path">
        @if (isset($classMaterial->upload_file_path))
            {!! $classMaterial->upload_file_path !!}
        @endif
        </span>
    </p>
</div>

<!-- Upload File Type Field -->
<div id="div_classMaterial_upload_file_type" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('upload_file_type', 'Upload File Type:', ['class'=>'control-label']) !!} 
        <span id="spn_classMaterial_upload_file_type">
        @if (isset($classMaterial->upload_file_type))
            {!! $classMaterial->upload_file_type !!}
        @endif
        </span>
    </p>
</div>

<!-- Reference Material Url Field -->
<div id="div_classMaterial_reference_material_url" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('reference_material_url', 'Reference Material Url:', ['class'=>'control-label']) !!} 
        <span id="spn_classMaterial_reference_material_url">
        @if (isset($classMaterial->reference_material_url))
            {!! $classMaterial->reference_material_url !!}
        @endif
        </span>
    </p>
</div>

