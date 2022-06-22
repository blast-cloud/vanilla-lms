@extends('layouts.app')

@section('title_postfix')
    Semester Details
@stop

@section('page_title')
    Semester Details 
    @if (isset($semester->unique_code)) 
       : <small>{{ $semester->unique_code }} 
    @endif
@stop


@section('content')

    @include('flash::message')

    <div class="col-sm-9">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    
                    <div class="form-wrap">
                        <div class="row pull-right">
                           <!--  <a href="#"  class="btn btn-primary btn-sm">Deadline</a> -->
                            <a href="#"  class="btn btn-sm btn-success btn-new-mdl-semester-notification-modal">
                               Add Notification
                            </a>
                        </div>
                        <div class="row">
                            <a class="btn btn-default btn-sm" href="{{ route('semesters.index') }}"><span class="fa fa-angle-left"></span> Go Back </a>
                            <hr class="light-grey-hr mb-10">
                            @if (isset($semester->is_current))
                                @if($semester->is_current == 1)
                                    <i><small style="color:green;"><strong>NOTE:</strong> This semester is currently active! </small></i>
                                @elseif ($semester->is_current == 0)
                                    <i><small style="color:red;"><strong>NOTE:</strong> This semester is not currently active! </small></i>
                                    @if(isset($current_semester))
                                        @if(!empty($current_semester))
                                            <br><i><small style="color:green;"><strong>CURRENT SEMESTER:</strong> {{ $current_semester->code }}, {{ $current_semester->academic_session }} Academic Session! </small></i>
                                        @endif
                                    @endif
                                @endif
                            @endif
                            <hr class="light-grey-hr mb-10">
                        </div>
                        <div class="row">
                            @include('semesters.show_fields')
                        </div>
                    </div>
                </div>
            </div>
            <div class="row col-sm-12">
                <div class="tab-struct custom-tab-1 mt-20">
                    <ul role="tablist" class="nav nav-pills">
                        @php
                            if(isset($_GET['offeredclasses'])){
                                $clicked1 = "primary";
                                $clicked2 = "default";
                            } elseif (isset($_GET['notifications'])){
                                $clicked1 = "default";
                                $clicked2 = "primary";
                            } else {
                                $clicked1 = "primary";
                                $clicked2 = "default";
                            }
                        @endphp
                        <form action="{{ URL::to('/semesters')}}/tabs/{{$semester->id}}" method="GET">
                            <li class="mr-2" role="presentation">
                                <button type="submit" name="offeredclasses" class="btn btn-{{$clicked1}} pt-10 pb-10 pl-5 pr-5" value="allOfferedClasses">
                                    Semester Offered Classes 
                                </button>
                                <button type="submit" name="notifications" class="btn btn-{{$clicked2}} active pt-10 pb-10 pl-5 pr-5" value="allNotifications">
                                    Semester Notifications 
                                </button>
                            </li>
                        </form>
                    </ul>
                    <div class="tab-content" id="myTabContent_6">
                        <!-- datatale for all offered courses & notifications -->
                        <div id="offeredClasses" class="tab-pane fade active in" role="tabpanel">
                            <div class="col-sm-12 panel panel-default card-view pa-20">
                                @include("semesters.semester-offered-classes-tab")
                            </div>
                        </div>
                        <!-- <div id="semesterDeadlines" class="tab-pane fade" role="tabpanel">
                            <div class="col-sm-12 panel panel-default card-view pa-20">
                                include("semesters.semester-notifications-tab")
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <div class="col-sm-3">
        @include("dashboard.partials.side-panel")
        @include('semesters.semester-notification-modal')
    </div>
    
@endsection
