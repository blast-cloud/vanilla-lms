<!-- Code Field -->
<div id="div-code" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="code">Code</label>
    <div class="col-sm-9">
        {!! Form::text('code', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Start Date Field -->
<div id="div-start_date" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="start_date">Start Date</label>
    <div class="col-sm-4">
        {!! Form::text('start_date', null, ['class' => 'form-control','id'=>'start_date']) !!}
    </div>
</div>


@push('app_js1')
    <script type="text/javascript">
        $('#start_date').datetimepicker({
            //format: 'YYYY-MM-DD HH:mm:ss',
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- End Date Field -->
<div id="div-end_date" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="end_date">End Date</label>
    <div class="col-sm-4">
        {!! Form::text('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
    </div>
</div>


@push('app_js1')
    <script type="text/javascript">
        $('#end_date').datetimepicker({
            //format: 'YYYY-MM-DD HH:mm:ss',
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush