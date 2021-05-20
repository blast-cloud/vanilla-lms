<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>
            {{$app_settings['txt_long_name']??''}}
            @yield('title', config('app.title', 'LMS'))
            @yield('title_prefix')
            @yield('title_postfix', config('app.title_postfix', ''))
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
	</head>
	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		
		<div class="wrapper error-page pa-0">
			<header class="sp-header">
				<div class="sp-logo-wrap pull-left">
					<!-- <a href="/">
						<img class="brand-img mr-10" src="{{ asset('dist/img/logo.png') }}" alt="brand"/>
						<span class="brand-text">PAT</span>
					</a> -->
				</div>
				<div class="form-group mb-0 pull-right">
					<!-- <a class="inline-block btn btn-info btn-rounded btn-outline nonecase-font" href="/">Home</a> -->
				</div>
				<div class="clearfix"></div>
			</header>
			
			<!-- Main Content -->
			<div class="page-wrapper pa-0 ma-0 error-bg-img">
				<div class="container-fluid">

                <div class="mt-30 mb-30 text-center">
                    @if (isset($app_settings['file_high_res_picture']))
                        {{-- <img src= "{{ asset('dist/img/logouzzz.jpg') }}" style="width:100px;height:100px;" class="user-auth-img"> --}}
                        <img src= "{{ asset($app_settings['file_high_res_picture']) }}" style="width:100px;height:100px;" class="user-auth-img">
                    @endif

                    <h3 class="text-center txt-dark mb-10">
                        {!! $app_settings['txt_long_name'] ?? '' !!}
                        {{-- Zambezi University --}}
                    </h3>
                    <h6 class="text-center nonecase-font txt-grey">
                        {!! $app_settings['txt_app_name'] ?? '' !!}
                        {{-- ETECH DEMO SCHOOL --}}
                    </h6>
                </div>

                <div class="row ma-20">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view pb-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pb-0">
                                    <div class="row">
                                        <!-- item -->
                                        <div class="col-lg-3 col-md-6 col-sm-12 text-center mb-30">
                                            <div class="panel panel-pricing mb-0">
                                                <div class="panel-heading">
                                                    <h4>Student</h4>
                                                </div>
                                                <div class="panel-body text-center pl-0 pr-0">
                                                    <hr class="mb-10">
                                                    <ul class="list-group mb-0 text-center">
                                                        <li class="list-group-item">
                                                            <b>Username</b><br/>mike@vanilla-lms.edu.ng<br/>
                                                            <b>Password</b><br/>password
                                                        </li>
                                                        <li><hr class="mt-5 mb-5"></li>
                                                    </ul>
                                                </div>
                                                <div class="panel-footer pb-20">
                                                    <a class="btn btn-success btn-lg" href="{{ route('login') }}">Login</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /item -->

                                        <!-- item -->
                                        <div class="col-lg-3 col-md-6 col-sm-12 text-center mb-30">
                                            <div class="panel panel-pricing mb-0">
                                                <div class="panel-heading">
                                                    <h4>Lecturer</h4>
                                                </div>
                                                <div class="panel-body text-center pl-0 pr-0">
                                                    <hr class="mb-10">
                                                    <ul class="list-group mb-0 text-center">
                                                        <li class="list-group-item">
                                                            <b>Username</b><br/>yohan@vanilla-lms.edu.ng<br/>
                                                            <b>Password</b><br/>password
                                                        </li>
                                                        <li><hr class="mt-5 mb-5"></li>
                                                    </ul>
                                                </div>
                                                <div class="panel-footer pb-20">
                                                    <a class="btn btn-success btn-lg" href="{{ route('login') }}">Login</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /item -->

                                        <!-- item -->
                                        <div class="col-lg-3 col-md-6 col-sm-12 text-center mb-30">
                                            <div class="panel panel-pricing mb-0">
                                                <div class="panel-heading">
                                                    <h4>Department</h4>
                                                </div>
                                                <div class="panel-body text-center pl-0 pr-0">
                                                    <hr class="mb-10">
                                                    <ul class="list-group mb-0 text-center">
                                                        <li class="list-group-item">
                                                            <b>Username</b><br/>ngo@vanilla-lms.edu.ng<br/>
                                                            <b>Password</b><br/>password
                                                        </li>
                                                        <li><hr class="mt-5 mb-5"></li>
                                                    </ul>
                                                </div>
                                                <div class="panel-footer pb-20">
                                                    <a class="btn btn-success btn-lg" href="{{ route('login') }}">Login</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /item -->


                                        <!-- item -->
                                        <div class="col-lg-3 col-md-6 col-sm-12 text-center mb-30">
                                            <div class="panel panel-pricing mb-0">
                                                <div class="panel-heading">
                                                    <h4>Admin</h4>
                                                </div>
                                                <div class="panel-body text-center pl-0 pr-0">
                                                    <hr class="mb-10">
                                                    <ul class="list-group mb-0 text-center">
                                                        <li class="list-group-item">
                                                            <b>Username</b><br/>admin@zambezi.edu.ng<br/>
                                                            <b>Password</b><br/>password
                                                        </li>
                                                        <li><hr class="mt-5 mb-5"></li>
                                                    </ul>
                                                </div>
                                                <div class="panel-footer pb-20">
                                                    <a class="btn btn-success btn-lg" href="{{ route('login') }}">Login</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /item -->                            

                                    </div>	
                                </div>	
                            </div>	
                        </div>	
                    </div>	
                </div>
                

				</div>
			</div>
			<!-- /Main Content -->
		
		</div>
		<!-- /#wrapper -->
		
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

