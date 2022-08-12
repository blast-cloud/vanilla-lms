@extends('layouts.app')


@section('title_postfix')
Lecturer Dashboard
@stop

@section('page_title')
{{$current_user->department->name}} :: Lecturer Dashboard
@stop



@section('content')
    
    @include('flash::message')

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
                            <h4 class="text-danger">You are NOT assigned to teach any class</h4>
                            <p class="muted">Please contact your department to assign classes for you on this platform</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="col-sm-3">
        @include("dashboard.partials.side-panel")
    </div>

@endsection

