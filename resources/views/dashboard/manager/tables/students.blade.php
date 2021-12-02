@extends('layouts.app')

@section('title_postfix')
@if (isset($department) && $department!=null)
{{ $department->name }} - Students
@endif
@stop

@section('page_title')
@if (isset($department) && $department!=null)
{{ $department->name }}
@endif
@stop


@section('app_css')
    @include('layouts.datatables_css')
@endsection


@section('content')
    
    <div class="col-sm-9">

        <div class="panel panel-default card-view panel-refresh">
            <div class="panel-heading" style="padding: 10px 15px;">
                <div class="pull-left">
                    <h4 class="txt-primary mt-5">Students</h4>
                </div>
                <div class="pull-right">
                    <div class="pull-left inline-block dropdown">
                        <a id="btn-show-modify-student-modal" href="#" class="btn-new-mdl-student-modal btn btn-primary btn-xs"><i class="icon wb-reply" aria-hidden="true"></i>Enroll New Student</a>
                        <a data-toggle="modal" data-target="#mdl-bulk-student-modal" href="#" class="btn btn-primary-alt btn-xs"><i class="icon wb-reply" aria-hidden="true"></i>Bulk upload</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}
            </div>
        </div>
        
    </div>
    <div class="col-sm-3">

        @include("dashboard.partials.side-panel")

    </div>

    @include('dashboard.manager.modals.modify-student')

@endsection



@push('app_js')

    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}

    <script src="{{ asset('vendors/bower_components/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('vendors/bower_components/jquery.counterup/jquery.counterup.min.js') }}"></script>

@endpush

