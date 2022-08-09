<!-- Email Field -->
<div id="div-email" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="email">Email</label>
    <div class="col-sm-9">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Telephone Field -->
<div id="div-telephone" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="telephone">Telephone</label>
    <div class="col-sm-9">
        {!! Form::text('telephone', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Job Title Field -->
<div id="div-job_title" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="job_title">Job Title</label>
    <div class="col-sm-9">
        {!! Form::text('job_title', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- First Name Field -->
<div id="div-first_name" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="first_name">First Name</label>
    <div class="col-sm-9">
        {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Last Name Field -->
<div id="div-last_name" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="last_name">Last Name</label>
    <div class="col-sm-9">
        {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Sex Field -->
<div id="div-sex" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="sex"> Sex </label>
    <div class="col-sm-9">
       <select name="sex" id="sex" class="form-control">
            <option value=''>
                -- Choose sex --
            </option>
            <option value="male">
                Male
            </option>
            <option value="Female">
                Female
            </option>
       </select>
    </div>
</div>