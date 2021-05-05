<!-- Email Field -->
<div id="div_manager_email" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('email', 'Email:', ['class'=>'control-label']) !!} 
        <span id="spn_manager_email">
        @if (isset($manager->email))
            {!! $manager->email !!}
        @endif
        </span>
    </p>
</div>

<!-- Telephone Field -->
<div id="div_manager_telephone" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('telephone', 'Telephone:', ['class'=>'control-label']) !!} 
        <span id="spn_manager_telephone">
        @if (isset($manager->telephone))
            {!! $manager->telephone !!}
        @endif
        </span>
    </p>
</div>

<!-- Job Title Field -->
<div id="div_manager_job_title" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('job_title', 'Job Title:', ['class'=>'control-label']) !!} 
        <span id="spn_manager_job_title">
        @if (isset($manager->job_title))
            {!! $manager->job_title !!}
        @endif
        </span>
    </p>
</div>

<!-- First Name Field -->
<div id="div_manager_first_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('first_name', 'First Name:', ['class'=>'control-label']) !!} 
        <span id="spn_manager_first_name">
        @if (isset($manager->first_name))
            {!! $manager->first_name !!}
        @endif
        </span>
    </p>
</div>

<!-- Last Name Field -->
<div id="div_manager_last_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('last_name', 'Last Name:', ['class'=>'control-label']) !!} 
        <span id="spn_manager_last_name">
        @if (isset($manager->last_name))
            {!! $manager->last_name !!}
        @endif
        </span>
    </p>
</div>

