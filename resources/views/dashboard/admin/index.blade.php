@extends('layouts.app')


@section('title_postfix')
Admin Dashboard
@stop

@section('page_title')
Admin Dashboard
@stop



@section('content')
    
        @include('flash::message')

    
        <div class="col-sm-9">

            @php
                // dd (isset($current_semester));
                // dd($current_semester);
            @endphp

            @if (isset($current_semester) && $current_semester==null)
                <div class="text-left alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    No current <strong>Semester</strong> set in the system. You have to setup the current semester.
                    <a id="btn-new-semester" href="#" class="ma-10 btn btn-xs btn-danger btn-new-mdl-semester-modal pull-right"><i class="zmdi zmdi-home"></i>&nbsp;Start New Semester</a>
                </div>
            @endif

            {{-- @include('dashboard.admin.partials.semesters') --}}
            <div class="row">
                <div class="col-md-6">
                    @include('dashboard.admin.partials.announcements')
                </div>
                <div class="col-md-6">
                    @include('dashboard.admin.partials.managers')
                </div>
                <div class="col-md-6">
                    @include('dashboard.admin.partials.lecturers')
                </div>
                <div class="col-md-6">
                    @include('dashboard.admin.partials.departments')
                </div>
            </div>


        </div>
        <div class="col-sm-3">

            @include("dashboard.partials.side-panel")

        </div>



@endsection

