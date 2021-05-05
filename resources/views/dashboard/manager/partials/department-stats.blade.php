
@if (isset($department) && $department!=null)
@php

    $course_count = count($department->courses);
    $class_count = count($department->courseClasses);
    $lecturer_count = count($class_schedules_unassigned);

@endphp
@if ( $course_count==0 || $class_count==0 || ($lecturer_count>0) )
<div class="col-sm-12">
    <div class="panel panel-default card-view">
        <div class="panel-body" style="padding: 10px 15px;">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="list-icons">
                        @if ($course_count==0)
                        <li class="mb-10"><i class="txt-danger fa fa-times mr-5"></i> <span class="text-info">Your course catalog contains 0 courses. Please update it. </span></li>
                        @endif
                        @if ($class_count==0)
                        <li class="mb-10"><i class="txt-danger fa fa-times mr-5"></i> <span class="text-info">Your class schedule has 0 classes. Please add classes for the courses being offered. </span></li>
                        @endif
                        @if ($lecturer_count>0)
                        <li class="mb-10"><i class="txt-danger fa fa-times mr-5"></i> <span class="text-info">You  need to assign lecturers for {{$lecturer_count}} out of {{$class_count}} classes. Please assign them. </span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endif


<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="panel panel-default card-view pa-0">
        <div class="panel-wrapper collapse in">
            <div class="panel-body pa-0">
                <div class="sm-data-box">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-7 text-center pl-0 pr-0 data-wrap-left">
                                <span class="txt-dark block counter"><span class="counter-anim">{{ number_format($student_count) }}</span></span>
                                <span class="weight-500 uppercase-font block font-13">Students</span>
                            </div>
                            <div class="col-xs-5 text-center  pl-0 pr-0 data-wrap-right">
                                <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="panel panel-default card-view pa-0">
        <div class="panel-wrapper collapse in">
            <div class="panel-body pa-0">
                <div class="sm-data-box">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-7 text-center pl-0 pr-0 data-wrap-left">
                                <span class="txt-dark block counter"><span class="counter-anim">{{ number_format($class_count,0) }}</span></span>
                                <span class="weight-500 uppercase-font block">Online Classes</span>
                            </div>
                            <div class="col-xs-5 text-center  pl-0 pr-0 data-wrap-right">
                                <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="panel panel-default card-view pa-0">
        <div class="panel-wrapper collapse in">
            <div class="panel-body pa-0">
                <div class="sm-data-box">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-7 text-center pl-0 pr-0 data-wrap-left">
                                <span class="txt-dark block counter"><span class="counter-anim">{{ number_format($course_count,0) }}</span></span>
                                <span class="weight-500 uppercase-font block">Course Catalog</span>
                            </div>
                            <div class="col-xs-5 text-center  pl-0 pr-0 data-wrap-right">
                                <i class="icon-layers data-right-rep-icon txt-light-grey"></i>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
