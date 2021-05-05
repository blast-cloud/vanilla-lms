<!DOCTYPE html>
<html lang="en">
	<head>
        <title>
            @yield('title_prefix', config('app.title_prefix', ''))
            @yield('title', config('app.title', 'LMS'))
            @yield('title_postfix', config('app.title_postfix', ''))
        </title>
        <meta name="description" content="Learning Management System." />
        <meta name="keywords" content="LMS, VanillaLMS, Foresight" />
        
        <!-- Favicon -->
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
                
        <!-- Bootstrap Wysihtml5 css -->
        <link rel="stylesheet" href="{{ asset('vendors/bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.css') }}" />
	
        <!-- Bootstrap Datetimepicker CSS -->
        <link href="{{ asset('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
            
        <!-- Bootstrap Daterangepicker CSS -->
        <link href="{{ asset('vendors/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>

        <!-- Custom CSS -->
        <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet" type="text/css" />
        
	</head>
	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		
		<div class="wrapper theme-1-active pimary-color-blue">
			
            <form method="post" action="{{ url('/login') }}">
            @csrf

                <!-- Main Content -->
                <div class="page-wrapper pa-0 ma-0 auth-page">
                    <div class="container-fluid">
                        <!-- Row -->
                        <div class="table-struct full-width full-height">
                            <div class="table-cell vertical-align-middle auth-form-wrap">
                                <div class="auth-form  ml-auto mr-auto no-float">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                        
                                            <div class="mb-30 text-center">
                                                <img src= "{{ asset('dist/img/logouzzz.jpg') }}" style="width:100px;height:100px;" class="user-auth-img">
                                                <h3 class="text-center txt-dark mb-10">Zambezi University</h3>
                                                <h6 class="text-center nonecase-font txt-grey">Login to eLearning Portal</h6>
                                            </div>	

                                            <div class="mb-30">
                                                @if ($errors->any())
                                                <div class="alert alert-danger alert-dismissible" style="margin:15px;">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <h4><i class="icon fa fa-warning"></i> Errors!</h4>
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif

                                                @if ($message = Session::get('error'))
                                                <div class="alert alert-danger alert-block" style="margin:15px;">
                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @endif


                                                @if ($message = Session::get('warning'))
                                                <div class="alert alert-warning alert-block" style="margin:15px;">
                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @endif


                                                @if ($message = Session::get('info'))
                                                <div class="alert alert-info alert-block" style="margin:15px;">
                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @endif


                                            </div>

                                            <div class="form-group">
                                                <label class="control-label mb-10" for="exampleInputEmail_2">{{ __('E-Mail Address') }}</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="pull-left control-label mb-10" for="exampleInputpwd_2">Password</label>
                                                <a class="capitalize-font txt-primary block mb-10 pull-right font-12" href="{{ route('password.request') }}">forgot password ?</a>
                                                <div class="clearfix"></div>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary pr-10 pull-left">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label for="checkbox_2"> Keep me logged in</label>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-primary">Log in</button>
                                            </div>
                                            
                                        </div>	
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Row -->	
                    </div>
                    
                </div>
                <!-- /Main Content -->
            
            </form>

            <footer class="footer container-fluid pl-30 pr-30"> 
				<div class="row">
					<div class="col-sm-5" style="font-size:80%">
                        {{ date('Y') }} &copy; ForesightLMS by <a href="http://etechcompletesolutions.com" target="_blank">E-TECH</a>
						<!-- <ul class="footer-link nav navbar-nav">
							<li class="logo-footer"><a href="#">help</a></li>
							<li class="logo-footer"><a href="#">terms</a></li>
							<li class="logo-footer"><a href="#">privacy</a></li>
						</ul> -->
					</div>
					<div class="col-sm-7 text-right" style="font-size:80%">
						SPONSORED BY <a href="https://www.tetfund.gov.ng" target="_blank">TETFUND/ICT/2019-20</a>
					</div>	
				</div>	
			</footer>

		</div>
		<!-- /#wrapper -->
		
        <!-- jQuery -->
        <script src="{{ asset('vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="{{ asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

        <!-- wysuhtml5 Plugin JavaScript -->
        <script src="{{ asset('vendors/bower_components/wysihtml5x/dist/wysihtml5x.min.js') }}"></script>

        <script src="{{ asset('vendors/bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.js') }}"></script>

        <!-- Fancy Dropdown JS -->
        <script src="{{ asset('dist/js/dropdown-bootstrap-extended.js') }}"></script>

        <!-- Bootstrap Wysuhtml5 Init JavaScript -->
        <script src="{{ asset('dist/js/bootstrap-wysuhtml5-data.js') }}"></script>

        <!-- Slimscroll JavaScript -->
        <script src="{{ asset('dist/js/jquery.slimscroll.js') }}"></script>

        <!-- Owl JavaScript -->
        <script src="{{ asset('vendors/bower_components/owl.carousel/dist/owl.carousel.min.js') }}"></script>

        <!-- Switchery JavaScript -->
        <script src="{{ asset('vendors/bower_components/switchery/dist/switchery.min.js') }}"></script>

        <!-- Init JavaScript -->
        <script src="{{ asset('dist/js/init.js') }}"></script>		
	</body>
</html>
