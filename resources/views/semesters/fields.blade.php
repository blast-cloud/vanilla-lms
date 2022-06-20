<!-- Academic Session -->
<div id="div-code" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="academic_session">Academic Session</label>
    <div class="col-sm-9">
        <select class = "form-control" name="academic_session" id="academic_session">
            <option value="">None selected</option>
            @php
                $loop_limit = 10;
                $loop_begin = intval(date('Y') + 1);
                for ($initial = 0; $initial < $loop_limit; $initial++){
                    $neededSession = strval($loop_begin - 1) . "/$loop_begin";
                    echo "<option value='$neededSession'>$neededSession</option>";
                    $loop_begin -= 1;
                }
            @endphp
        </select>
    </div>
</div>

    <!-- Code Field -->
    <div id="div-code" class="form-group">
        <label class="control-label mb-10 col-sm-3" for="code">Semester Code</label>
        <div class="col-sm-9">
            <select name="code" id="code" class="form-control">
                <option value="">Select Semester Code</option>
                <option value="First Semester">First Semester</option>
                <option value="Second Semester">Second Semester</option>
            </select>
        </div>
    </div>

    <!-- Start Date Field -->
    <div id="div-start_date" class="form-group">
        <label class="control-label mb-10 col-sm-3" for="start_date">Start Date</label>
        <div class="col-sm-4">
            {!! Form::text('start_date', null, ['class' => 'form-control','id'=>'start_date']) !!}
        </div>
    </div>


    <!-- End Date Field -->
    <div id="div-end_date" class="form-group">
        <label class="control-label mb-10 col-sm-3" for="end_date">End Date</label>
        <div class="col-sm-4">
            {!! Form::text('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
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

        $('#end_date').datetimepicker({
            //format: 'YYYY-MM-DD HH:mm:ss',
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush