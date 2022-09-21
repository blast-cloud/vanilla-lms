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
                    <a id="btn-new-department" href="#" class="btn btn-xs btn-default btn-new-mdl-department-modal mt-5 col-xs-9 col-sm-6"><i class="zmdi zmdi-home"></i> New Department</a>
                    <a data-toggle="modal" data-target="#mdl-bulk-department-modal" href="#" class="btn btn-primary-alt btn-xs mt-5 col-xs-9 col-sm-6"><i class="zmdi zmdi-upload" aria-hidden="true"></i>Bulk upload</a>
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

