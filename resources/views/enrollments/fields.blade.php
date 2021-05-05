<!-- Status Field -->
<div id="div-status" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="status">Status</label>
    <div class="col-sm-9">
        {!! Form::text('status', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Student Id Field -->
<div id="div-student_id" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="student_id">Student Id</label>
    <div class="col-sm-9">
        {!! Form::select('student_id', $StudentItems, null, ['class' => 'form-control custom-select']) !!}
    </div>
</div>

