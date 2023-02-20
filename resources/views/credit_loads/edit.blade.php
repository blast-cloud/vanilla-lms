@extends('layouts.app')

@section('title_postfix')
Edit Credit Load
@stop

@section('page_title')
Edit Credit Load
@stop


@section('content')

        <div class="col-sm-9">
            <div class="panel panel-default card-view">

                <div class="panel-wrapper collapse in">
                    <div class="panel-body">

                        <div class="col-sm-8">
                            <div class="form-wrap">
                                {{-- {!! Form::model($level, ['class'=>'form-horizontal', 'route' => ['levels.update', $level->id], 'method' => 'patch', 'files' => true]) !!} --}}

                                @include('credit_loads.fields')

                                <div class="col-sm-offset-3 col-sm-9">
                                    <br/>
                                    <hr class="light-grey-hr mb-10">
                                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                    <a href="{{ route('credit_loads.index') }}" class="btn btn-default">Cancel</a>
                                </div>
                                {!! Form::close() !!}                        
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <blockquote class="muted" style="color:#9a9696;font-size:90%;border-left: 4px solid #c9c7f3;">
                                This is the help message <br/><br/>
                                This is the help message <br/><br/>
                                This is the help message <br/>
                            </blockquote>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-sm-3">
            @include("dashboard.partials.side-panel")
        </div>

@endsection
