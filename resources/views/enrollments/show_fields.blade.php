{{-- <!-- Student Id Field -->
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
 --}}
<!-- Student Id Field -->
<div id="div_enrollment_matriculation_number" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('matriculation_number', 'Matriculation Number:', ['class'=>'control-label']) !!} 
        <span id="spn_enrollment_matriculation_number">
        @if (isset($enrollment->student))
            {!! $enrollment->student->matriculation_number !!}
        @endif
        </span>
    </p>
</div>
<!-- Student Id Field -->
<div id="div_enrollment_student_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('student_name', 'Matriculation Number:', ['class'=>'control-label']) !!} 
        <span id="spn_enrollment_student_name">
        @if (isset($enrollment->student))
            {!! $enrollment->student->first_name !!}    {!! $enrollment->student->last_name !!}
        @endif
        </span>
    </p>
</div>



<!-- course class Field -->
<div id="div_enrollment_course_class" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('course_class', 'Course Class:', ['class'=>'control-label']) !!} 
        <span id="spn_enrollment_course_class">
        @if (isset($enrollment->course_class))
            {!! $enrollment->course_class->code !!} {!! $enrollment->course_class_name->last_name !!}
        @endif
        </span>
    </p>
</div>

{{-- <!-- Status Field -->
<div id="div_enrollment_status" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('status', 'Status:', ['class'=>'control-label']) !!} 
        <span id="spn_enrollment_status">
        @if (isset($enrollment->status))
            {!! $enrollment->status !!}
        @endif
        </span>
    </p>
</div> --}}



