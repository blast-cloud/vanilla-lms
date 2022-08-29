<div class="row">
    <div class="col-lg-10 ma-10">
        <!-- Semester notification title -->
        <div id="div-tit" class="form-group">
            <label class="control-label mb-10 col-sm-3" for="is_current">Notification title</label>
            <div class="col-sm-9">
                <input type="text" name="title" class = "form-control" id="title" placeholder="Notification title">
            </div>
        </div>
        <!-- Semester notification message -->
        <div id="div-mes" class="form-group">
            <label class="control-label mb-10 col-sm-3" for="is_current">Notification message</label>
            <div class="col-sm-9">
                <textarea name="message" class = "form-control" id="message" placeholder="Notification message" rows="6"></textarea>
            </div>
        </div>
        <!-- Semester to notification message -->
        <div id="div-rec" class="form-group">
            <label class="control-label mb-10 col-sm-3" for="is_current">Select recepient groups</label>
            <div class="col-sm-9">
                <div class="col-sm-4">

                    <input type="checkbox" name="managers" id="managers"> <label for="managers">All Managers</label>
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" name="lecturers" id="lecturers"> <label for="lecturers">All Lecturers</label>
                </div>
                <div class="col-sm-4">
                    <input type="checkbox" name="students" id="students"> <label for="students">All Students</label>
                </div>
            </div>
        </div>
    </div>
</div>