<!-- Title Field -->
<div id="div-title" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="title">Title</label>
    <div class="col-sm-9">
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Due Date Field -->
<div id="div-due_date" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="due_date">Due Date</label>
    <div class="col-sm-4">
        {!! Form::text('due_date', null, ['class' => 'form-control','id'=>'due_date']) !!}
    </div>
</div>


@push('app_js1')
    <script type="text/javascript">
        $('#due_date').datetimepicker({
            //format: 'YYYY-MM-DD HH:mm:ss',
            format: 'DD-MM-YYYY',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Description Field -->
<div id="div-description" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="description">Description</label>
    <div class="col-sm-9">
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>
</div>