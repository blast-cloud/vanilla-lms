@extends('layouts.app')


@section('title_postfix')
User Accounts 
@stop

@section('page_title')
User Accounts 
@stop

@section('app_css')
    @include('layouts.datatables_css')
@endsection

@section('content')
    
    @include('flash::message')

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="user-block">

                        <h4>
                            <div class="pull-right">
                                <a id="btn-show-modify-user-details-modal" href="#" class="btn btn-xs btn-default"><i class="fa fa-user"></i>&nbsp;Create User</a>
                                <!-- <a href="#" class="btn btn-xs btn-default"><i class="fa fa-key"></i>&nbsp;Bulk Password</a> -->
                            </div>
                        </h4>

                        <div class="box box-info">
                            <div class="panel-body">
                                {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    @include("acl.modals.display-user-details")
    @include("acl.modals.password-reset")
@stop


@section('js-111')
<script type="text/javascript">
    $(document).ready(function() { 



    });
</script>

@include('layouts.datatables_js')
{!! $dataTable->scripts() !!}
@stop
