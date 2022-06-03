<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 id="lbl-feedback-request-modal-title" class="modal-title">Feedback Request</h4>
</div>
<div class="modal-body">
    <div id="div-feedback-request-modal-error" class="alert alert-danger" role="alert"></div>
    <form class="form-horizontal" id="frm-feedback-request-modal" role="form" method="POST" enctype="multipart/form-data" action="">
        <div class="row">
            <div class="col-lg-12 ma-10">
                @csrf
                <div id="spinner1" class="spinner">
                    <div class="loader" id="loader-1"></div>
                </div>
                <input type="hidden" id="txt-feedback-request-primary-id" value="0" />
                <input type="hidden" id="txt_creator_user_id" value="0" />
                <input type="hidden" id="txt_department_id" value="0" />
                <div class="form-wrap">
                    <!-- Start Date Field -->
                    <div class="form-group">
                        <label class="control-label mb-10 col-sm-3" for="txt_feedback_request_start_date">Start Date</label>
                        <div class="col-sm-2">
                            {!! Form::text('txt_feedback_request_start_date', null, ['id'=>'txt_feedback_request_start_date', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                        <!-- End Date Field -->
                        <div class="form-group">
                        <label class="control-label mb-10 col-sm-3" for="txt_feedback_request_due_date">Due Date</label>
                        <div class="col-sm-2">
                            {!! Form::text('txt_feedback_request_due_date', null, ['id'=>'txt_feedback_request_due_date', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                        <!-- Remarks Field -->
                        <div class="form-group">
                        <label class="control-label mb-10 col-sm-3" for="txt_feedback_request_remarks">Remarks</label>
                        <div class="col-sm-7">
                            {!! Form::textarea('txt_feedback_request_remarks', null, ['id'=>'txt_feedback_request_remarks', 'class' => 'form-control', 'rows'=>'6']) !!}
                        </div>
                    </div>
                <div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <hr class="light-grey-hr mb-10" />
    <button type="button" class="btn btn-primary" id="btn-save-feedback-request-modal" value="add">Save</button>
</div>
</div>
</div>
