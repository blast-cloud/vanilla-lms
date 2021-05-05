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


            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default card-view panel-refresh">
                        <div class="refresh-container">
                            <div class="la-anim-1"></div>
                        </div>
                        <div class="panel-heading" style="padding: 10px 15px;">
                            <div class="pull-left">
                                <h4 class="panel-title txt-dark">Semesters</h4>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('dashboard.class',0) }}" class="btn btn-xs btn-primary pull-left inline-block mr-15">
                                    <i class="zmdi zmdi-collection-text" style="font-size:inherit;color:white;"></i>&nbsp; Add Semester
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="panel-body" style="padding: 10px 15px;">
                            <div class="row">
                                <div class="col-sm-12">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default card-view panel-refresh">
                        <div class="refresh-container">
                            <div class="la-anim-1"></div>
                        </div>
                        <div class="panel-heading" style="padding: 10px 15px;">
                            <div class="pull-left">
                                <h4 class="panel-title txt-dark">Departments</h4>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('dashboard.class',0) }}" class="btn btn-xs btn-primary pull-left inline-block mr-15">
                                    <i class="zmdi zmdi-collection-bookmark" style="font-size:inherit;color:white;"></i>&nbsp; Add Department
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="panel-body" style="padding: 10px 15px;">
                            <div class="row">
                                <div class="col-sm-12">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default card-view panel-refresh">
                        <div class="refresh-container">
                            <div class="la-anim-1"></div>
                        </div>
                        <div class="panel-heading" style="padding: 10px 15px;">
                            <div class="pull-left">
                                <h4 class="panel-title txt-dark">Staff List</h4>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('dashboard.class',0) }}" class="btn btn-xs btn-primary pull-left inline-block mr-15">
                                    <i class="zmdi zmdi-collection-bookmark" style="font-size:inherit;color:white;"></i>&nbsp; Add Staff
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="panel-body" style="padding: 10px 15px;">
                            <div class="row">
                                <div class="col-sm-12">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="col-sm-3">

            @include("dashboard.partials.side-panel")

        </div>



@endsection

