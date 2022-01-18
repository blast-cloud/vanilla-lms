@extends('layouts.app')


@section('title_postfix')
Account Profile
@stop

@section('page_title')
Account Profile
@stop


@section('content')
    
    @include('flash::message')

    <div class="col-sm-9">

        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body" style="padding: 10px 5px 5px 15px;">

                    <div class="col-sm-10">
                        <div class="form-wrap">
                            <form method="post" action="{{ route('profile-update') }}" class='form-horizontal'>
                                @csrf

                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-3" for="code">Email Address</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="email"
                                                id="email"
                                                name="email"
                                               
                                                value="{{ old('email', $current_user->email) }}"
                                                class="form-control @error('email') is-invalid @enderror" 
                                                placeholder="Email" 
                                                 @if ($current_user->student_id != null)
                                                    disabled
                                                 @endif>
>
                                            @error('email')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-3" for="code">Telephone #</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="number"
                                                id="telephone"
                                                name="telephone"
                                                value="{{ old('telephone', $current_user->telephone) }}"
                                                class="form-control @error('telephone') is-invalid @enderror"
                                                placeholder="Telephone Number">
                                            @error('telephone')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-3" for="code">Password</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="password"
                                                id="password"
                                                name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Password">
                                            @error('password')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-3" for="code">Retype Password</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="password"
                                                id="password_confirmation"
                                                name="password_confirmation"
                                                class="form-control"
                                                placeholder="Retype password">
                                        </div>
                                    </div>
                                </div>

                                <hr class="light-grey-hr mb-10">

                                @if ($current_user->student_id != null)
                                <div class="form-group">
                                    <label class="control-label mb-5 col-sm-3" for="code">Registration#</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-5" style="padding-top:7px;">
                                            {{ $matric_num }}
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label class="control-label mb-5 col-sm-3" for="code">First Name</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-5" style="padding-top:7px;">
                                            {{ $first_name }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-5 col-sm-3" for="code">Last Name</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-5" style="padding-top:7px;">
                                            {{ $last_name }}
                                        </div>
                                    </div>
                                </div>
                                @if($current_user->department)
                                <div class="form-group">
                                    <label class="control-label mb-5 col-sm-3" for="code">Department</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-5" style="padding-top:7px;">
                                            {{ $current_user->department->name }}
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <hr class="light-grey-hr mb-10">

                                <div class="col-sm-offset-3 col-sm-9 mb-20">
                                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                    <a href="{{ URL::previous() }}" class="btn btn-default">Cancel</a>
                                </div>

                            </form>
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

