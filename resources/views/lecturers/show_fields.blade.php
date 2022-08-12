<!-- Email Field -->
<div id="div_lecturer_email" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('email', 'Email:', ['class'=>'control-label']) !!} 
        <span id="spn_lecturer_email">
        @if (isset($lecturer->email))
            {!! $lecturer->email !!}
        @endif
        </span>
    </p>
</div>

<!-- Telephone Field -->
<div id="div_lecturer_telephone" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('telephone', 'Telephone:', ['class'=>'control-label']) !!} 
        <span id="spn_lecturer_telephone">
        @if (isset($lecturer->telephone))
            {!! $lecturer->telephone !!}
        @endif
        </span>
    </p>
</div>

<!-- Job Title Field -->
<div id="div_lecturer_job_title" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('job_title', 'Job Title:', ['class'=>'control-label']) !!} 
        <span id="spn_lecturer_job_title">
        @if (isset($lecturer->job_title))
            {!! $lecturer->job_title !!}
        @endif
        </span>
    </p>
</div>

<!-- First Name Field -->
<div id="div_lecturer_first_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('first_name', 'First Name:', ['class'=>'control-label']) !!} 
        <span id="spn_lecturer_first_name">
        @if (isset($lecturer->first_name))
            {!! $lecturer->first_name !!}
        @endif
        </span>
    </p>
</div>

<!-- Last Name Field -->
<div id="div_lecturer_last_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('last_name', 'Last Name:', ['class'=>'control-label']) !!} 
        <span id="spn_lecturer_last_name">
        @if (isset($lecturer->last_name))
            {!! $lecturer->last_name !!}
        @endif
        </span>
    </p>
</div>

<!-- Last Name Field -->
<div id="div_lecturer_sex" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('sex', 'Sex:', ['class'=>'control-label']) !!} 
        <span id="spn_lecturer_last_name">
        @if (isset($lecturer->sex))
            {!! $lecturer->sex !!}
        @endif
        </span>
    </p>
</div>

