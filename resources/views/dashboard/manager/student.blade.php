@extends('layouts.app')

@section('title_postfix')
@if (isset($student) && $student!=null)
    {{$student->first_name}} {{$student->last_name}} :: {{ $student->matriculation_number }}
@endif
@stop

@section('page_title')
@if (isset($student) && $student!=null)
    {{$student->first_name}} {{$student->last_name}} :: {{ $student->matriculation_number }}
@endif
@stop


@section('app_css')
    @include('layouts.datatables_css')
@endsection


@section('content')
    
    <div class="col-sm-9">
        @if(isset($current_semester))
            @if(!empty($current_semester))
                <small style="color: green;"><strong>CURRENT SEMESTER:</strong> {{$current_semester->code}}, {{$current_semester->academic_session}} Academic Session</small><br>
            @endif
        @endif
        <div class="panel panel-default card-view panel-refresh">
            <div class="panel-heading" style="padding: 10px 15px;">
                <div class="pull-left">
                    <h4 class="txt-primary mt-5">Student Profile</h4>
                </div>
                <div class="pull-right">
                    <div class="pull-left inline-block dropdown">
                        @if (isset($student) && !$student->has_graduated)  
                            <a id="btn-show-modify-student-modal" href="#" class="btn-new-mdl-enrollment-modal btn btn-primary btn-xs"><i class="icon wb-reply" aria-hidden="true"></i>Enroll in Class</a>
                            <a href="#" data-toggle="modal" data-target="#mdl-unenrollment-modal" class="btn btn-danger btn-xs"><i class="icon wb-reply" aria-hidden="true"></i>Withdraw from class</a> 
                        @endif
                       
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                @include('students.show_fields')
                
                {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}
            </div>
        </div>
        
    </div>
    <div class="col-sm-3">

        @include("dashboard.partials.side-panel")

    </div>

    @include('dashboard.manager.modals.modify-student-enrollment')

@endsection



@push('app_js')

    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}

    <script src="{{ asset('vendors/bower_components/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('vendors/bower_components/jquery.counterup/jquery.counterup.min.js') }}"></script>

@endpush

