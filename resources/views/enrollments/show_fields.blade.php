<!-- Status Field -->
<div id="div_enrollment_status" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('status', 'Status:', ['class'=>'control-label']) !!} 
        <span id="spn_enrollment_status">
        @if (isset($enrollment->status))
            {!! $enrollment->status !!}
        @endif
        </span>
    </p>
</div>

<!-- Student Id Field -->
<div id="div_enrollment_student_id" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('student_id', 'Student Id:', ['class'=>'control-label']) !!} 
        <span id="spn_enrollment_student_id">
        @if (isset($enrollment->student_id))
            {!! $enrollment->student_id !!}
        @endif
        </span>
    </p>
</div>

