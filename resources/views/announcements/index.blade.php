@extends('layouts.app')


@section('title_postfix')
Announcements
@stop

@section('page_title')
Announcements
@stop



@section('content')
    
    @include('flash::message')

    <div class="col-sm-9">
        <div class="panel panel-default card-view">
            <div class="panel-heading" style="padding: 10px 15px;">
                <div class="pull-left"></div>
                @if ((auth()->user()->is_platform_admin == true))
                    <div class="pull-right">
                        <a id="btn-show-modify-announcement-modal" class="btn btn-primary btn-xs btn-new-mdl-announcement-modal" href="#" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Add Announcement</a>
                    </div>
                @endif
                <div class="clearfix"></div>
            </div>
            @if ((auth()->user()->is_platform_admin == 1))

                {{-- <div class="pull-right">
                    <div class="pull-left inline-block dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                        <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                            <li role="presentation"><a id="btn-show-modify-announcement-modal" class="btn-new-mdl-announcement-modal" href="#" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Add Announcement</a></li>
                            <li role="presentation"><a href="{{ route('dashboard.manager.announcements') }}" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Manage</a></li>
                        </ul>
                    </div>                
                </div> --}}
                
            @endif

            <div class="panel-wrapper collapse in">
                <div class="panel-body">

                    <div class="table-wrap">
                        <div class="table-responsive">
                            @include('announcements.table')

                            
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="col-sm-3">
        @include("dashboard.partials.side-panel")
    </div>

    @include('announcements.modal')
@endsection

