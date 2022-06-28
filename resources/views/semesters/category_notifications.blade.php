@extends('layouts.app')


@section('title_postfix')
    Notifications
@stop

@section('page_title')
    Dashboard Notifications
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
    @include('semesters.notifications-modal')
@endsection

