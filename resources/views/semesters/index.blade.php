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

                <div class="panel-heading" style="padding: 10px 15px;">
                
                    <div class="pull-left">
                        <h4 class="txt-primary mt-5"></h4>
                    </div>
                    <div class="pull-right">
                        <div class="pull-left inline-block dropdown">
                            
                            <a href="#"  class="btn btn-xs btn-primary btn-new-mdl-semester-modal">
                                Create New Semester
                            </a>
                            <a href="#"  class="btn btn-xs btn-success btn-commence-a-semester-modal">
                                Commence Semester
                            </a>
                        </div>
                    </div>
                    <div class="clearfix"></div>                
    
                </div>

                <div class="panel-body">
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
    @include('semesters.commence_semesters_modal')
@endsection

