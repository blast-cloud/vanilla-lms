@extends('layouts.app')


@section('title_postfix')
FAQs and Help
@stop

@section('page_title')
FAQs and Help
@stop


@section('content')
    
    @include('flash::message')

    <div class="col-sm-9">
        <div class="panel panel-default card-view">

            <div class="panel-heading" style="padding: 10px 15px;">
                <div class="pull-left"></div>
                <div class="pull-right">
                    <a id="btn-new-mdl-faq-modal" href="#" class="btn btn-xs btn-default btn-new-mdl-faq-modal"><i class="zmdi zmdi-help"></i>&nbsp;Add FAQ or Question</a>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="panel-wrapper collapse in">
                <div class="panel-body">

                    <div class="table-wrap">
                        <div class="table-responsive">
                            @include('faqs.table')
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="col-sm-3">
        @include("dashboard.partials.side-panel")
    </div>

    @include('faqs.modal')
@endsection

