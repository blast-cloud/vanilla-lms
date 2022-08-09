<!-- Email Field -->
<div id="div-email" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="email">Email</label>
    <div class="col-sm-9">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Matriculation Number Field -->
<div id="div-matriculation_number" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="matriculation_number">Matriculation Number</label>
    <div class="col-sm-9">
        {!! Form::text('matriculation_number', null, ['class' => 'form-control']) !!}
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

<!-- Gender Field -->
<div id="div-telephone" class="form-group">
    <label class="control-label mb-10 col-sm-3 text-right" for="sex">Sex</label>
    <div class="col-sm-9">
       <select name="sex" id="sex" class="form-control">
            <option value="">
                -- Select Gender --
            </option>
            <option value="Male">
                Male
            </option>
            <option value="Female">
                Female
            </option>
       </select>
    </div>
</div>
<!-- Telephone Field -->
<div id="div-telephone" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="telephone">Telephone</label>
    <div class="col-sm-9">
        {!! Form::text('telephone', null, ['class' => 'form-control']) !!}
    </div>
</div>
<!-- Level Field -->
<div id="div-level" class="form-group">
    <label class="control-label mb-10 col-sm-3 text-right" for="sex">Level</label>
    <div class="col-sm-9">
       <select name="level" id="level" class="form-control">
            <option value="">
                -- Select Level --
            </option>
            @foreach ($levels as $level)
                <option value="{{$level->level}}">
                   {{$level->name}}
                </option>
            @endforeach
           
       </select>
    </div>  
</div>