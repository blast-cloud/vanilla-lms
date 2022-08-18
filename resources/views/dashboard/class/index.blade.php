@extends('layouts.app')

@section('cdn_scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
<script type="text/javascript" src="https://unpkg.com/face-api.js@0.22.2/dist/face-api.min.js"></script>
@endsection


@section('title_postfix')
{{ ($courseClass) ?  $courseClass->code : '' }} :: {{ ($courseClass) ? $courseClass->name : '' }}
@stop

@section('page_title')
{{ ($courseClass) ? $courseClass->code : '' }} :: {{ ($courseClass) ? $courseClass->name : '' }}<br/>
<small class="muted text-primary"><i>Taught by {{ ($courseClass && $courseClass->lecturer) ? $courseClass->lecturer->job_title : '' }} {{ ($courseClass && $courseClass->lecturer) ? $courseClass->lecturer->first_name : '' }} {{ ($courseClass && $courseClass->lecturer) ? $courseClass->lecturer->last_name : '' }}</i></small>
<br/>
@stop



@section('content')
    
    @include('flash::message')


    <div class="col-sm-9">

        <div class="tab-struct custom-tab-1 mt-20">
            <ul role="tablist" class="nav nav-pills" id="myTabs_6">
                <li class="active mr-2" role="presentation"><a class="pt-10 pb-10 pl-5 pr-5" aria-expanded="true" data-toggle="tab" role="tab" id="home_tab_6" href="#home_6">Class Details</a></li>
                <li class="mr-2" role="presentation"><a class="pt-10 pb-10 pl-5 pr-5" data-toggle="tab" id="profile_tab_7" role="tab" href="#profile_7" aria-expanded="false">Lectures</a></li>                
                <li class="mr-2" role="presentation"><a class="pt-10 pb-10 pl-5 pr-5" data-toggle="tab" id="profile_tab_5" role="tab" href="#profile_5" aria-expanded="false">Assignments</a></li>
               {{--  @if (optional($current_semester)->id == $courseClass->semester_id)
                <li class="mr-2" role="presentation"><a class="pt-10 pb-10 pl-5 pr-5" data-toggle="tab" id="profile_tab_11" role="tab" href="#profile_11" aria-expanded="false">Exams</a></li>  
                @endif  --}}   
                <li class="mr-2" role="presentation"><a class="pt-10 pb-10 pl-5 pr-5" data-toggle="tab" id="profile_tab_6" role="tab" href="#profile_6" aria-expanded="false">Discussions <!-- <span style="font-size:60%;" class="label label-danger">10</span> --></a></li>
                <li class="mr-2" role="presentation"><a class="pt-10 pb-10 pl-5 pr-5" data-toggle="tab" id="profile_tab_8" role="tab" href="#profile_8" aria-expanded="false">Outline</a></li>
                @if ($current_user->manager_id !=null || $current_user->student_id != null)
                <li class="mr-2" role="presentation"><a class="pt-10 pb-10 pl-5 pr-5" data-toggle="tab" id="profile_tab_13" role="tab" href="#profile_13" aria-expanded="false">Feedbacks</a></li>
                @endif
                @if ($current_user->lecturer_id!=null)
                <li class="mr-2" role="presentation"><a class="pt-10 pb-10 pl-5 pr-5" data-toggle="tab" id="profile_tab_9" role="tab" href="#profile_9" aria-expanded="false">Grades</a></li>
                <li class="mr-2" role="presentation"><a class="pt-10 pb-10 pl-5 pr-5" data-toggle="tab" id="profile_tab_12" role="tab" href="#profile_12" aria-expanded="false">Students</a></li>
                <li class="mr-2" role="presentation"><a class="pt-10 pb-10 pl-5 pr-5" data-toggle="tab" id="profile_tab_10" role="tab" href="#profile_10" aria-expanded="false">Analytics</a></li>
                @endif
            </ul>
            <div class="tab-content" id="myTabContent_6">

                <div id="home_6" class="tab-pane fade active in" role="tabpanel">
                    <div class="col-sm-12 panel panel-default card-view pa-20">
                        @include("dashboard.class.partials.class_details")
                    </div>
                </div>

                <div id="profile_7" class="tab-pane fade" role="tabpanel">
                    <div class="col-sm-12 panel panel-default card-view pa-20">
                        @include("dashboard.class.partials.online_lectures")
                    </div>
                </div>

                <div id="profile_5" class="tab-pane fade" role="tabpanel">
                    <div class="col-sm-12 panel panel-default card-view pa-20">
                        @include("dashboard.class.partials.assignments")
                    </div>
                </div>

                {{-- <div id="profile_11" class="tab-pane fade" role="tabpanel">
                    <div class="col-sm-12 panel panel-default card-view pa-20">
                        @include("dashboard.class.partials.exams")
                    </div>
                </div> --}}

                <div id="profile_6" class="tab-pane fade" role="tabpanel">
                    <div class="col-sm-12 panel panel-default card-view pa-20">
                        @include("dashboard.class.partials.discussion_board")
                    </div>
                </div>

                <div id="profile_8" class="tab-pane fade" role="tabpanel">
                    <div class="col-sm-12 panel panel-default card-view pa-20">
                        @include("dashboard.class.partials.outline")
                    </div>
                </div>
                @if ($current_user->manager_id != null || $current_user->student_id != null)
                <div id="profile_13" class="tab-pane fade" role="tabpanel">
                    <div class="col-sm-12 panel panel-default card-view pa-20">
                        @include("dashboard.class.partials.feedbacks")
                    </div>
                </div>
                @endif
                
                @if ($current_user->lecturer_id!=null)
                <div id="profile_9" class="tab-pane fade" role="tabpanel">
                    <div class="col-sm-12 panel panel-default card-view pa-20">
                        @include("dashboard.class.partials.grades")
                    </div>
                </div>
                <div id="profile_10" class="tab-pane fade" role="tabpanel">
                    @include("dashboard.class.partials.student_class_activities")
                </div>
                <div id="profile_12" class="tab-pane fade" role="tabpanel">
                    <div class="col-sm-12 panel panel-default card-view pa-20">
                        @include("dashboard.class.partials.enrollments")
                    </div>
                </div>
                @endif
                
            </div>
        </div>

    </div>
    <div class="col-sm-3">

        @include("dashboard.partials.side-panel")
    </div>

    
    @include("dashboard.class.modals.modify-date")
    @include("dashboard.class.modals.lecture-start")
    @include("dashboard.class.modals.modify-outline")
    @include("dashboard.class.modals.view-discussion")
    @include("dashboard.class.modals.modify-assignment")
    @include("dashboard.class.modals.modify-announcement")
    @include("dashboard.class.modals.modify-examinations")
    @include("dashboard.class.modals.submit-assignment")
    @include("dashboard.class.modals.modify-class-details")
    @include('dashboard.student.modals.modify-enrollment')
    @include("dashboard.class.modals.modify-reading-material")
    @include("dashboard.class.modals.feedback")
    
       
@endsection

