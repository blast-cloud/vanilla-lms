@extends('layouts.app')


@section('title_postfix')
@if(config('lmsfaculty.faculty',true)) Faculties
@elseif(config('lmsfaculty.school',true)) Schools
@elseif(config('lmsfaculty.college',true)) Colleges 
@else
Faculties
@endif
@stop

@section('page_title')
@if(config('lmsfaculty.faculty',true))Faculties
@elseif(config('lmsfaculty.school',true)) Schools
@elseif(config('lmsfaculty.college',true)) Colleges 
@else
Faculties
@endif
@stop

@section('content')
    
    @include('flash::message')

    <div class="col-sm-9">
        <div class="panel panel-default card-view">


            <div class="panel-heading" style="padding: 10px 15px;">
                <div class="pull-left"></div>
                <div class="pull-right">
                    <a id="btn-new-faculty" href="#" class="btn btn-xs btn-default btn-new-mdl-faculty-modal mt-5 col-xs-9 col-sm-6"><i class="zmdi zmdi-home"></i> New @if(config('lmsfaculty.faculty',true))<span class="right-nav-text">Faculty</span>
                        @elseif(config('lmsfaculty.college',true))<span class="right-nav-text">College</span>
                        @elseif(config('lmsfaculty.school',true))<span class="right-nav-text">School</span>
                        @else
                        <span class="right-nav-text">Faculty</span>
                        @endif
                    </a>
                    <a data-toggle="modal" data-target="#mdl-bulk-faculty-modal" href="#" class="btn btn-primary-alt btn-xs mt-5 col-xs-9 col-sm-6"><i class="zmdi zmdi-upload" aria-hidden="true"></i>Bulk upload</a>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="panel-wrapper collapse in">
                <div class="panel-body">

                    <div class="table-wrap">
                        <div class="table-responsive">
                            @include('faculties.table')                
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="col-sm-3">
        @include("dashboard.partials.side-panel")
    </div>

    @include('faculties.modal')
@endsection

