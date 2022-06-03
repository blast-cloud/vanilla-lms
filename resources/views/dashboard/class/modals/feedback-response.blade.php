<div class="modal-dialog modal-lg" role="document">
 <div class="modal-content">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 id="lbl-feedback-response-modal-title" class="modal-title">Feedback Response</h4>
</div>

<div class="modal-body">
<div id="div-feedback-response-modal-error" class="alert alert-danger" role="alert"></div>
<form class="form-horizontal" id="frm-feedback-response-modal" role="form" method="POST" enctype="multipart/form-data" action="">
    <div class="row">
        <div class="col-lg-12 ma-10">
            @csrf

            <div id="spinner1" class="spinner">
                <div class="loader" id="loader-1"></div>
            </div>

            <input type="hidden" id="txt-feedback-response-primary-id" value="0" />
            <input type="hidden" id="txt_feedback_request_id" value="0" />
            <input type="hidden" id="txt_student_id" value="0"/>
            <div class="form-wrap">
                    <!-- Assignment Rating Field -->
                <div id="div-assignment_rating" class="form-group">
                    <label class="control-label col-sm-3" for="txt_feedback_response_assignment_rating">Assignment Rating</label>
                        <div class="col-sm-4">
                        <select name="assignments_rating_point" id="txt_feedback_response_assignment_rating" class="form-control">
                            <option value="5">
                                5 
                            </option>
                            <option value="4">
                                4
                            </option>
                            <option value="3">
                                3 
                            </option>
                            <option value="2">
                                2 
                            </option>
                            <option value="1">
                                1 
                            </option>
                        </select>
                    </div>
                </div>
                    <!-- Clarification Rating Field -->
                    <div id="div-clarification_rating" class="form-group">
                    <label class="control-label col-sm-3" for="txt_feedback_response_clarification_rating">Clarification Rating</label>
                        <div class="col-sm-4">
                        <select name="clarification_rating_point" id="txt_feedback_response_clarification_rating" class="form-control">
                            <option value="5">
                                5
                            </option>
                            <option value="4">
                                4 
                            </option>
                            <option value="3">
                                3 
                            </option>
                            <option value="2">
                                2 
                            </option>
                            <option value="1">
                                1 
                            </option>
                        </select>
                    </div>
                </div>
                <!-- Examination Rating Field -->
                <div id="div-examination_rating" class="form-group">
                    <label class="control-label col-sm-3" for="examination_rating">Examination Rating</label>
                        <div class="col-sm-4">
                        <select name="examination_rating_point" id="txt_feedback_response_examination_rating" class="form-control">
                            <option value="5">
                                5 
                            </option>
                            <option value="4">
                                4
                            </option>
                            <option value="3">
                                3 
                            </option>
                            <option value="2">
                                2
                            </option>
                            <option value="1">
                                1 
                            </option>
                        </select>
                    </div>
                </div>
                    <!-- Teaching Rating Field -->
                    <div id="div-teaching_rating" class="form-group">
                    <label class="control-label col-sm-3" for="txt_feedback_response_teaching_rating">Teaching Rating</label>
                        <div class="col-sm-4">
                        <select name="teaching_rating_point" id="txt_feedback_response_teaching_rating" class="form-control">
                            <option value="5">
                                5 
                            </option>
                            <option value="4">
                                4 
                            </option>
                            <option value="3">
                                3 
                            </option>
                            <option value="2">
                                2 
                            </option>
                            <option value="1">
                                1 
                            </option>
                        </select>
                    </div>
                </div>
                    <!-- Remarks Field -->
                    <div class="form-group">
                    <label class="control-label mb-10 col-sm-3" for="txt_feedback_response_remarks">Remarks</label>
                    <div class="col-sm-7">
                        {!! Form::textarea('txt_feedback_response_remarks', null, ['id'=>'txt_feedback_response_remarks', 'class' => 'form-control', 'rows'=>'6']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
<div class="modal-footer">
    <hr class="light-grey-hr mb-10" />
    <button type="button" class="btn btn-primary" id="btn-save-feedback-response-modal" value="add">Save</button>
</div>

    </div>
</div>