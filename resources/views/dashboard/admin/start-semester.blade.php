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


                {{-- <div class="panel-heading" style="padding: 10px 15px;">
                </div> --}}
                
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pt-0">
    
                    
                        <span class="small text-danger">
                            <i>Starting a new semester will <strong>AFFECT</strong> the current Semester. Before starting a new semester, please make sure that the current semester has actually ended and classes are not ongoing. Click the Start New Semester Button to commence the process.</i>
                        </span>

                        <div class="pull-left"></div>
                        <div class="pull-right">
                            <a id="btn-new-semester" href="#" class="ma-10 btn btn-xs btn-default btn-new-mdl-semester-modal"><i class="zmdi zmdi-home"></i>&nbsp;Start New Semester</a>
                        </div>
                        <div class="clearfix"></div>


                        <div class="table-wrap">
                            <div class="table-responsive">
                                
    
                                
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



@section('js-112')
<script type="text/javascript">
$(document).ready(function() {


});
</script>
@endsection