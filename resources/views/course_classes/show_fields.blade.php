<!-- Code Field -->
<div id="div_courseClass_code" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('code', 'Code:', ['class'=>'control-label']) !!} 
        <span id="spn_courseClass_code">
        @if (isset($courseClass->code))
            {!! $courseClass->code !!}
        @endif
        </span>
    </p>
</div>

<!-- Name Field -->
<div id="div_courseClass_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('name', 'Name:', ['class'=>'control-label']) !!} 
        <span id="spn_courseClass_name">
        @if (isset($courseClass->name))
            {!! $courseClass->name !!}
        @endif
        </span>
    </p>
</div>

<!-- Email Address Field -->
<div id="div_courseClass_email_address" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('email_address', 'Email Address:', ['class'=>'control-label']) !!} 
        <span id="spn_courseClass_email_address">
        @if (isset($courseClass->email_address))
            {!! $courseClass->email_address !!}
        @endif
        </span>
    </p>
</div>

<!-- Telephone Field -->
<div id="div_courseClass_telephone" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('telephone', 'Telephone:', ['class'=>'control-label']) !!} 
        <span id="spn_courseClass_telephone">
        @if (isset($courseClass->telephone))
            {!! $courseClass->telephone !!}
        @endif
        </span>
    </p>
</div>

<!-- Location Field -->
<div id="div_courseClass_location" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('location', 'Location:', ['class'=>'control-label']) !!} 
        <span id="spn_courseClass_location">
        @if (isset($courseClass->location))
            {!! $courseClass->location !!}
        @endif
        </span>
    </p>
</div>

<!-- Credit Hours Field -->
<div id="div_courseClass_credit_hours" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('credit_hours', 'Credit Hours:', ['class'=>'control-label']) !!} 
        <span id="spn_courseClass_credit_hours">
        @if (isset($courseClass->credit_hours))
            {!! $courseClass->credit_hours !!}
        @endif
        </span>
    </p>
</div>

<!-- Next Lecture Date Field -->
<div id="div_courseClass_next_lecture_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('next_lecture_date', 'Next Lecture Date:', ['class'=>'control-label']) !!} 
        <span id="spn_courseClass_next_lecture_date">
        @if (isset($courseClass->next_lecture_date))
            {!! $courseClass->next_lecture_date !!}
        @endif
        </span>
    </p>
</div>

<!-- Next Exam Date Field -->
<div id="div_courseClass_next_exam_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('next_exam_date', 'Next Exam Date:', ['class'=>'control-label']) !!} 
        <span id="spn_courseClass_next_exam_date">
        @if (isset($courseClass->next_exam_date))
            {!! $courseClass->next_exam_date !!}
        @endif
        </span>
    </p>
</div>

<!-- Outline Field -->
<div id="div_courseClass_outline" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('outline', 'Outline:', ['class'=>'control-label']) !!} 
        <span id="spn_courseClass_outline">
        @if (isset($courseClass->outline))
            {!! $courseClass->outline !!}
        @endif
        </span>
    </p>
</div>

