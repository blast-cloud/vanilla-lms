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


            {{-- @include('dashboard.admin.partials.semesters') --}}
            @include('dashboard.admin.partials.departments')
            @include('dashboard.admin.partials.lecturers')
            @include('dashboard.admin.partials.managers')


        </div>
        <div class="col-sm-3">

            @include("dashboard.partials.side-panel")

        </div>



@endsection

