@extends('layouts.app')


@section('title_postfix')
Departments
@stop

@section('page_title')
Departments
@stop



@section('content')
    
    @include('flash::message')

    <div class="col-sm-9">
        <div class="panel panel-default card-view">


            <div class="panel-heading" style="padding: 10px 15px;">
                <div class="pull-left"></div>
                <div class="pull-right">
                    <a id="btn-new-department" href="#" class="btn btn-xs btn-default btn-new-mdl-department-modal"><i class="zmdi zmdi-home"></i>&nbsp;New Department</a>
                    <a class="btn btn-xs btn-primary pull-right ml-10"href="#" data-toggle="modal" data-target="#mdl-bulk-department-modal">
                        <i class="fa fa-upload" style="color: black;"></i> Bulk upload
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="panel-wrapper collapse in">
                <div class="panel-body">

                    <div class="table-wrap">
                        <div class="table-responsive">
                            @include('departments.table')

                            
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="col-sm-3">
        @include("dashboard.partials.side-panel")
    </div>

    @include('departments.modal')
@endsection

