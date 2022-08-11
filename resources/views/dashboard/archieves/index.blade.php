@extends('layouts.app')


@section('title_postfix')
Student Dashboard
@stop

@section('page_title')
@php
    $title = '';
    if($current_user->lecturer_id != null){
        $title = "Lecturer Course Class Achieves";
    }elseif ($current_user->manager_id != null) {
        # code...
        $title = "Course Class Achieves";
    }else{
        $title = "Student Course Class Achieves";
    }
@endphp
{{$current_user->department->name}} :: {{$title}}
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
                                <h4 class="text-danger">No Items found in Archieve</h4>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-sm-12">
                    {{ $class_schedules->links() }}
                </div>
            </div>
           
           
        </div>
        <div class="col-sm-3">

            @include("dashboard.partials.side-panel")

        </div>
@include('dashboard.student.modals.modify-enrollment')
@endsection

