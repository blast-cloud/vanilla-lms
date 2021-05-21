@extends('layouts.app')


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
                <li class="active" role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab" id="home_tab_6" href="#home_6">Class Details</a></li>
                
                <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_7" role="tab" href="#profile_7" aria-expanded="false">Lectures</a></li>
                
                <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_5" role="tab" href="#profile_5" aria-expanded="false">Assignments</a></li>
                <!-- <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_6" role="tab" href="#profile_6" aria-expanded="false">Discussions <span style="font-size:60%;" class="label label-danger">10</span></a></li> -->
                <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_8" role="tab" href="#profile_8" aria-expanded="false">Outline</a></li>
                <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_9" role="tab" href="#profile_9" aria-expanded="false">Grades</a></li>
                <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_10" role="tab" href="#profile_10" aria-expanded="false">Students</a></li>
            </ul>
            <div class="tab-content" id="myTabContent_6">

                <div id="home_6" class="tab-pane fade active in" role="tabpanel">
                    @include("dashboard.class.partials.class_details")
                </div>

                <div id="profile_7" class="tab-pane fade" role="tabpanel">
                    @include("dashboard.class.partials.online_lectures")
                </div>

                <div id="profile_5" class="tab-pane fade" role="tabpanel">
                    @include("dashboard.class.partials.assignments")
                </div>

                <!-- <div id="profile_6" class="tab-pane fade" role="tabpanel">
                    @include("dashboard.class.partials.discussion_board")
                </div> -->

                <div id="profile_8" class="tab-pane fade" role="tabpanel">
                    @include("dashboard.class.partials.outline")
                </div>

                <div id="profile_9" class="tab-pane fade" role="tabpanel">
                    @include("dashboard.class.partials.grades")
                </div>
                
                <div id="profile_10" class="tab-pane fade" role="tabpanel">
                    @include("dashboard.class.partials.enrollments")
                </div>
            </div>
        </div>

    </div>
    <div class="col-sm-3">

        @include("dashboard.partials.side-panel")
    </div>

    @include("dashboard.class.modals.modify-date")
    @include("dashboard.class.modals.lecture-start")
    @include("dashboard.class.modals.modify-outline")
    @include("dashboard.class.modals.modify-assignment")
    @include("dashboard.class.modals.modify-announcement")
    @include("dashboard.class.modals.modify-class-details")
    @include("dashboard.class.modals.modify-reading-material")
    
@endsection

