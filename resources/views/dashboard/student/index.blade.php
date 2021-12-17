@extends('layouts.app')


@section('title_postfix')
Student Dashboard
@stop

@section('page_title')
Student Dashboard
@stop



@section('content')
    
        @include('flash::message')
        @php 
        if (isset($classActivities) && $classActivities->getAppSettings()){
            $db_settings = $classActivities->getAppSettings();
        }
    @endphp
    @if(!empty($db_settings) && $db_settings['cbx_class_enrollment'] != null)
        <div class="row" >
            <div class="col-xs-9" >
                <span class="pull-right"  style="padding-bottom: 10px; padding-right: 5px ">
                    <a href="#" id="btn-show-modify-student-modal" href="#" class="btn-new-mdl-enrollment-modal btn btn-xs btn-primary pull-right">
                        <i class="zmdi zmdi-file-plus"></i> Enroll&nbsp;in&nbsp;class
                    </a>
                </span>
            </div>
        </div>
    @endif
    
        <div class="col-sm-9">

            @if (isset($class_schedules) && $class_schedules!=null && count($class_schedules)>0)
            @foreach($class_schedules as $classDetailItem)
                @include("dashboard.class.partials.class-list-details")
            @endforeach
            @else
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view panel-refresh">
                            <div class="refresh-container">
                                <div class="la-anim-1"></div>
                            </div>
                            <div class="panel-heading text-center mb-20 mt-10">
                                <h4 class="text-danger">You are NOT enrolled in any classes</h4>
                                <p class="muted">Please contact your department to enroll you for classes on this Platform</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
        <div class="col-sm-3">

            @include("dashboard.partials.side-panel")

        </div>
@include('dashboard.student.modals.modify-enrollment')
@endsection

