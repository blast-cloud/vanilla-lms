@extends('layouts.app')


@section('title_postfix')
Semesters
@stop

@section('page_title')
Semesters
@stop



@section('content')
    
    @include('flash::message')

    <div class="col-sm-9">
        <div class="panel panel-default card-view">

            <div class="panel-wrapper collapse in">
                <div class="panel-body">

                    <p><a href="#"  class="btn btn-xs btn-primary btn-new-mdl-semester-modal">
                        <i class="fa fa-plus" style=""></i> Create New Semester
                    </a> </p> <br>

                    <div class="table-wrap">
                        <div class="table-responsive">
                            @include('semesters.table')

                            
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="col-sm-3">
        @include("dashboard.partials.side-panel")
    </div>

    @include('semesters.modal')
@endsection

