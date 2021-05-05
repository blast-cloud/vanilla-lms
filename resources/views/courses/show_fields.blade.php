<!-- Code Field -->
<div id="div_course_code" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('code', 'Code:', ['class'=>'control-label']) !!} 
        <span id="spn_course_code">
        @if (isset($course->code))
            {!! $course->code !!}
        @endif
        </span>
    </p>
</div>

<!-- Name Field -->
<div id="div_course_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('name', 'Name:', ['class'=>'control-label']) !!} 
        <span id="spn_course_name">
        @if (isset($course->name))
            {!! $course->name !!}
        @endif
        </span>
    </p>
</div>

<!-- Description Field -->
<div id="div_course_description" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('description', 'Description:', ['class'=>'control-label']) !!} 
        <span id="spn_course_description">
        @if (isset($course->description))
            {!! $course->description !!}
        @endif
        </span>
    </p>
</div>

<!-- Credit Hours Field -->
<div id="div_course_credit_hours" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('credit_hours', 'Credit Hours:', ['class'=>'control-label']) !!} 
        <span id="spn_course_credit_hours">
        @if (isset($course->credit_hours))
            {!! $course->credit_hours !!}
        @endif
        </span>
    </p>
</div>

