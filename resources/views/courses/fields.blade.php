<!-- Code Field -->
<div id="div-code" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="code">Code</label>
    <div class="col-sm-9">
        {!! Form::text('code', null, ['id' => 'course_code','class' => 'form-control']) !!}
    </div>
</div>

<!-- Name Field -->
<div id="div-name" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="name">Course Title</label>
    <div class="col-sm-9">
        {!! Form::text('name', null, ['id' => 'course_name','class' => 'form-control']) !!}
    </div>
</div>

<!-- Description Field -->
<div id="div-description" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="description">Description</label>
    <div class="col-sm-9">
        {!! Form::textarea('description', null, ['id' => 'course_description','class' => 'form-control']) !!}
    </div>
</div>

<!-- Credit Hours Field -->
<div id="div-credit_hours" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="credit_hours">Credit Hours</label>
    <div class="col-sm-3">
        {!! Form::number('credit_hours', null, ['id' => 'course_credit_hours','class' => 'form-control']) !!}
    </div>
    <label class="control-label mb-10 col-sm-1 text-left" for="level">Level</label>
    <div class="col-sm-5">
        <select name="level" id="course_level" class="form-control">
            <option value=""> -- select level --</option>
            @foreach ($levels as $item)
                <option value="{{$item->level}}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- <!-- Level Field -->
<div id="div-level" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="level">Credit Load</label>
    <div class="col-sm-3">
        {!! Form::number('level', null, ['class' => 'form-control']) !!}
    </div>
</div> --}}
