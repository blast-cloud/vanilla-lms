<!-- Code Field -->
<div id="div-code" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="code">Code</label>
    <div class="col-sm-9">
        {!! Form::text('code', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Name Field -->
<div id="div-name" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="name">Name</label>
    <div class="col-sm-9">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Email Address Field -->
<div id="div-email_address" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="email_address">Email Address</label>
    <div class="col-sm-9">
        {!! Form::email('email_address', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Telephone Field -->
<div id="div-telephone" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="telephone">Telephone</label>
    <div class="col-sm-9">
        {!! Form::text('telephone', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Location Field -->
<div id="div-location" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="location">Location</label>
    <div class="col-sm-9">
        {!! Form::text('location', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Credit Hours Field -->
<div id="div-credit_hours" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="credit_hours">Credit Hours</label>
    <div class="col-sm-3">
        {!! Form::number('credit_hours', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Next Lecture Date Field -->
<div id="div-next_lecture_date" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="next_lecture_date">Next Lecture Date</label>
    <div class="col-sm-4">
        {!! Form::text('next_lecture_date', null, ['class' => 'form-control','id'=>'next_lecture_date']) !!}
    </div>
</div>


@push('app_js1')
    <script type="text/javascript">
        $('#next_lecture_date').datetimepicker({
            //format: 'YYYY-MM-DD HH:mm:ss',
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Next Exam Date Field -->
<div id="div-next_exam_date" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="next_exam_date">Next Exam Date</label>
    <div class="col-sm-4">
        {!! Form::text('next_exam_date', null, ['class' => 'form-control','id'=>'next_exam_date']) !!}
    </div>
</div>


@push('app_js1')
    <script type="text/javascript">
        $('#next_exam_date').datetimepicker({
            //format: 'YYYY-MM-DD HH:mm:ss',
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Outline Field -->
<div id="div-outline" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="outline">Outline</label>
    <div class="col-sm-4">
        {!! Form::text('outline', null, ['class' => 'form-control','id'=>'outline']) !!}
    </div>
</div>


@push('app_js1')
    <script type="text/javascript">
        $('#outline').datetimepicker({
            //format: 'YYYY-MM-DD HH:mm:ss',
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush