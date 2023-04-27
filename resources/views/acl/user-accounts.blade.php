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
                                <a id="btn-show-modify-user-details-modal" href="#" class="btn btn-xs btn-default mt-5 col-xs-9 col-sm-6"><i class="fa fa-user"></i>&nbsp;Create User</a>
                                <a data-toggle="modal" data-target="#mdl-bulk-user-modal" href="#" class="btn btn-primary-alt btn-xs mt-5 col-xs-9 col-sm-6" style="height: 28px;"><i class="icon wb-reply" aria-hidden="true"></i>Bulk upload</a>
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

@include('layouts.datatables_js')
{!! $dataTable->scripts() !!}

<script type="text/javascript">
/* Override Export Button Actions */
$(document).ready(function() {
    //CSV Button
    $(document).on('click', '.buttons-csv', (e) => {
        e.preventDefault();
        var url = $(this).attr("href");
        window.open(url,"_blank");
    });
    //Excel Button
    $(document).on('click', '.buttons-excel', (e) => {
        e.preventDefault();
        var url = $(this).attr('href');
        window.open(url,"_blank");
    });
    
    //PDF Button
    $(document).on('click', '.buttons-pdf', (e) => {
        e.preventDefault();
        var url = $(this).attr('href');
        window.open(url,"_blank");
    }); 
});
</script>
@stop

