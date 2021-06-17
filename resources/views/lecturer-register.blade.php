<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>
            {{$app_settings['txt_long_name']??''}}
            @yield('title', config('app.title', 'LMS'))
            @yield('title_prefix')
            Student Registration
        </title>
        <meta name="description" content="{{$app_settings['txt_long_name']??''}} Learning Management System." />
        <meta name="keywords" content="LMS, VanillaLMS, Foresight, Hasob" />
        
		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
		<!-- vector map CSS -->
		<link href="{{ asset('vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
		
		<!-- Custom CSS -->
		<link href="{{ asset('dist/css/style.css') }}" rel="stylesheet" type="text/css">


        <style>
            .image-container {
                position: relative;
                text-align: center;
                color: white;
            }

            /* Bottom right text */
            .image-text-bottom-right {
                position: absolute;
                bottom: 8px;
                right: 16px;
            }

            /* Bottom left text */
            .image-text-bottom-left {
                position: absolute;
                bottom: 20px;
                left: 80px;
            }

        </style>


	</head>
	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->

        <div class="wrapper pa-0">
                
            <header class="sp-header">
                <div class="sp-logo-wrap pull-left">
                    <a href="/">
                        @if (isset($app_settings['file_icon_picture']))
                        <img class="brand-img mr-10" src="{{ asset($app_settings['file_icon_picture']) }}" alt="brand"/>
                        @endif
                        <span class="brand-text">{!! $app_settings['txt_long_name'] ?? '' !!}</span>
                    </a>
                </div>
                <div class="form-group mb-0 pull-right">
                    {{-- <a class="inline-block btn btn-info btn-rounded btn-outline nonecase-font" href="/">Home</a> --}}
                </div>
                <div class="clearfix"></div>
            </header>

            <div class="page-wrapper pa-20 ma-0">
                <div class="container-fluid">

                    <div class="row mt-50 ">

                        <div class="col-lg-8">

                            @if (isset($app_settings['cbx_allow_lecturer_registration']) && $app_settings['cbx_allow_lecturer_registration']==1)
                            <div class="col-lg-12 text-center">
                                <div class="panel panel-default card-view">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body pt-5" style="">
                                
                                            <div class="col-lg-12 text-center">
                                                <h4 class="text-center nonecase-font txt-grey">
                                                    Lecturer Registration
                                                </h4>
                                            </div>

                                            @if($errors->any())
                                            <div class="col-lg-12 mt-20">
                                                <div class="text-left alert alert-danger" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>

                                                    @foreach($errors->all() as $error)
                                                        {{ $error }}<br/>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif   

                                            <div class="col-lg-12 text-center mt-20">

                                                <form class="form-horizontal" id="frm-student-modal" role="form" method="POST" enctype="multipart/form-data" action="{{ route('lecturer-register') }}">
                                                    <div class="row">
                                                        <div class="col-lg-12 ma-10">
                                                            @csrf

                                                            <!-- Job Title Field -->
                                                            <div id="div-job_title" class="form-group">
                                                                <label class="control-label mb-10 col-sm-3" for="job_title">Title</label>
                                                                <div class="col-sm-4">
                                                                    {!! Form::text('job_title', null, ['id'=>'job_title','class' => 'form-control']) !!}
                                                                </div>
                                                            </div>

                                                            <!-- First Name Field -->
                                                            <div id="div-first_name" class="form-group">
                                                                <label class="control-label mb-10 col-sm-3" for="first_name">Full Name</label>
                                                                <div class="col-sm-4">
                                                                    {!! Form::text('first_name', null, ['id'=>'first_name','placeholder'=>'First Name','class' => 'form-control']) !!}
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    {!! Form::text('last_name', null, ['id'=>'last_name','placeholder'=>'Last Name','class' => 'form-control']) !!}
                                                                </div>
                                                            </div>

                                                            <!-- Department Field -->
                                                            <div id="div-department_id" class="form-group">
                                                                <label class="control-label mb-10 col-sm-3" for="department_id">Department</label>
                                                                <div class="col-sm-8">
                                                                    {!! Form::select('department_id', $departmentItems, null, ['id'=>'department_id','class'=>'form-control select2']) !!}
                                                                </div>
                                                            </div>

                                                            <!-- Email Field -->
                                                            <div id="div-email" class="form-group">
                                                                <label class="control-label mb-10 col-sm-3" for="email">Email Address</label>
                                                                <div class="col-sm-8">
                                                                    {!! Form::text('email', null, ['id'=>'email','class' => 'form-control']) !!}
                                                                </div>
                                                            </div>

                                                            <!-- Password Field -->
                                                            {{-- <div id="div-password" class="form-group">
                                                                <label class="control-label mb-10 col-sm-3" for="password">Password</label>
                                                                <div class="col-sm-4">
                                                                    {{ Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control' ) ) }}
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    {{ Form::password('password_confirmation', array('placeholder'=>'Confirm Password', 'class'=>'form-control' ) ) }}
                                                                </div>
                                                            </div> --}}

                                                            <!-- Last Name Field -->
                                                            {{-- <div id="div-last_name" class="form-group">
                                                                <label class="control-label mb-10 col-sm-3" for="last_name">Last Name</label>
                                                            </div> --}}

                                                            <!-- Telephone Field -->
                                                            <div id="div-telephone" class="form-group">
                                                                <label class="control-label mb-10 col-sm-3" for="telephone">Telephone</label>
                                                                <div class="col-sm-4">
                                                                    {!! Form::text('telephone', null, ['id'=>'telephone','class' => 'form-control']) !!}
                                                                </div>
                                                            </div>


                                                            <div class="col-lg-12 text-center mt-20">
                                                                
                                                                <hr class="light-grey-hr mb-10" />
                                                                @if (isset($app_settings['cbx_allow_lecturer_registration']) && $app_settings['cbx_allow_lecturer_registration']==1)
                                                                <button type="submit" class="btn btn-primary" id="btn-save-student-registration" value="save">Submit Registration</button>
                                                                @endif
                
                                                            </div>

                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>

                        <div class="col-lg-4">

                            <div class="col-lg-12 text-center">
                                <div class="panel panel-default card-view">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body pt-5" style="">
                                
                                            <div class="col-lg-12 text-center">
                                                @if (isset($app_settings['file_high_res_picture']))
                                                    <img src= "{{ asset($app_settings['file_high_res_picture']) }}" style="width:100px;height:100px;" class="user-auth-img">
                                                @endif
                                                <h3 class="text-center txt-dark mb-10">
                                                    {!! $app_settings['txt_short_name'] ?? '' !!}
                                                </h3>
                                                <h6 class="text-center nonecase-font txt-grey">
                                                    {!! $app_settings['txt_app_name'] ?? '' !!}
                                                </h6>
                                            </div>
                                            <div class="col-lg-12 text-center mt-20">
                                                <a class="btn btn-success btn-lg" href="{{ route('login') }}">Login</a>

                                                @if (isset($app_settings['cbx_allow_student_registration']) && $app_settings['cbx_allow_student_registration']==1)
                                                <a class="btn btn-success btn-lg" href="{{ route('student-register') }}">Register</a>
                                                @endif
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-12 mt-20">
                                @if (isset($app_settings['txt_portal_contact_phone']) || isset($app_settings['txt_portal_contact_email']) || isset($app_settings['txt_portal_contact_name']))
                                <div class="panel panel-default card-view">
                                    <div class="panel-heading pb-5" style="">
                                        <div class="pull-left">
                                            <h6 class="panel-title txt-dark">Help & Support</h6>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body pt-5" style="">
                                            <p>If you are having challenges with the portal please contact;</p>
                                            @if (isset($app_settings['txt_portal_contact_name']))
                                            <i class="fa fa-user ml-5 mr-5"></i> {{ $app_settings['txt_portal_contact_name'] }}<br/>
                                            @endif
                                            @if (isset($app_settings['txt_portal_contact_phone']))
                                            <i class="fa fa-phone ml-5 mr-5"></i> {{ $app_settings['txt_portal_contact_phone'] }}<br/>
                                            @endif
                                            @if (isset($app_settings['txt_portal_contact_email']))
                                            <i class="fa fa-envelope ml-5 mr-5"></i> {{ $app_settings['txt_portal_contact_email'] }}<br/>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                        </div>

                    </div>

                </div>

                <footer class="footer container-fluid pl-30 pr-30"> 
                    <div class="row">
                        <div class="col-sm-5" style="font-size:80%">
                            {{ date('Y') }} &copy; ForesightLMS by <a href="http://etechcompletesolutions.com" target="_blank">E-TECH</a>
                        </div>
                        <div class="col-sm-7 text-right" style="font-size:80%">
                            SPONSORED BY <a href="https://www.tetfund.gov.ng" target="_blank">TETFUND/ICT/2019-20</a>
                        </div>	
                    </div>	
                </footer>

            </div>

		</div>
		<!-- JavaScript -->
		
		<!-- jQuery -->
		<script src="{{ asset('vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="{{ asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js') }}"></script>
		
		<!-- Slimscroll JavaScript -->
		<script src="{{ asset('dist/js/jquery.slimscroll.js') }}"></script>
		
		<!-- Init JavaScript -->
		<script src="{{ asset('dist/js/init.js') }}"></script>
	</body>
</html>

