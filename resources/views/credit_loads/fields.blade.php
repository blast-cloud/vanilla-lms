<!-- Semester Field -->
<div class="form-group">
    <label class="control-label mb-10 col-sm-3" for="level">Semester</label>
    <div class="col-sm-9">
        <select class="form-control" id="semester_code" name="semester_code">
            <option value="">-- select semster --</option>
            @foreach ($semesters as $semester)
                <option value="{{ $semester->code }}">{{ $semester->code }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<!-- Level Field -->
<div class="form-group">
    <label class="control-label mb-10 col-sm-3" for="level">Level</label>
        <div class="col-sm-9">
            <select class="form-control" id="level" name="level">
                <option value="">-- select level--</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->level }}">{{ $level->level }}
                    </option>
                @endforeach
            </select>
        </div>
</div>
<!-- Max Credit Load Field-->
<div class="form-group">
    <label class="control-label mb-10 col-sm-3" for="max_credit_load">Max Credit Load</label>
    <div class="col-sm-9">
       <input type="number" name="max_credit_load" class="form-control" id="max_credit_load">
    </div>
</div>
