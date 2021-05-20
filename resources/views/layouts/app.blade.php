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
                
        <!-- Bootstrap Wysihtml5 css -->
        <link rel="stylesheet" href="{{ asset('vendors/bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.css') }}" />
	
        <!-- Bootstrap Datetimepicker CSS -->
        <link href="{{ asset('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
            
        <!-- Bootstrap Daterangepicker CSS -->
        <link href="{{ asset('vendors/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>

        <!-- Select2 CSS -->
        <link href="{{ asset('vendors/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css">

        <!-- Custom CSS -->
        <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet" type="text/css" />
        
        
        @yield('third_party_stylesheets')

        @stack('page_css')

        @stack('app_css')
        @yield('app_css')

        @stack('css-101')
        @yield('css-101')
        @stack('css-102')
        @yield('css-102')
        @stack('css-103')
        @yield('css-103')
        @stack('css-104')
        @yield('css-104')
        @stack('css-105')
        @yield('css-105')        

        <style>
            #dataTableBuilder_filter {
                width:250px;
            }
            #dataTableBuilder_filter>label>input {
                display: inherit;
                width:70%;
            }
            .paginate_button {
                padding: 0px 0px !important;
            }
            .pagination>li.active>a, 
            .pagination>li.active>span {
                background: #337ab7;
            }
            .pagination>.disabled>a, 
            .pagination>.disabled>a:focus, 
            .pagination>.disabled>a:hover,
            .pagination>.disabled>span, 
            .pagination>.disabled>span:focus,
            .pagination>.disabled>span:hover {
                border-color: #dedede;
                color: #337ab7;
            }

        </style>
    </head>

    <body>
        <!--Preloader-->
        <div class="preloader-it">
            <div class="la-anim-1"></div>
        </div>
        <!--/Preloader-->
        <div class="wrapper  theme-1-active pimary-color-pink">

            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="page-wrapper">
                <div class="container-fluid">
                    <!-- Title -->
                    <div class="row heading-bg">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <h4 class="txt-dark">@yield('page_title','')</h4>
                        </div>
                        <!-- Breadcrumb -->
                        @include('layouts.breadcrumbs')
                        <!-- /Breadcrumb -->
                    </div>
                    <!-- /Title -->                    
                </div>

                <div class="container-fluid">
                    <!-- Error -->
                    <div class="row">
                        @include('layouts.errors')
                    </div>
                    <!-- /Error -->
                </div>
                
                <div class="container-fluid">				
                    <div class="row">
                    <!-- Content -->
                    @yield('content')
                    <!-- /Content -->
                    </div>
                </div>
                                

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
            <!-- /Main Content -->

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
        
        <!-- Select2 JavaScript -->
        <script src="{{ asset('vendors/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

        <!-- Moment JavaScript -->
        <script type="text/javascript" src="{{ asset('vendors/bower_components/moment/min/moment-with-locales.min.js') }}"></script>
            
        <!-- Bootstrap Datetimepicker JavaScript -->
        <script type="text/javascript" src="{{ asset('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        
        <!-- Bootstrap Daterangepicker JavaScript -->
        <script src="{{ asset('vendors/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

        <!-- Init JavaScript -->
        <script src="{{ asset('dist/js/init.js') }}"></script>		

        @yield('third_party_scripts')
        @stack('third_party_scripts')

        @stack('page_scripts')

        <!-- JavaScript -->
        @yield('app_js')
        @stack('app_js')

        @yield('app_js1')
        @stack('app_js1')

        @stack('js-111')
        @yield('js-111')
        @stack('js-112')
        @yield('js-112')
        @stack('js-113')
        @yield('js-113')
        @stack('js-114')
        @yield('js-114')
        @stack('js-115')
        @yield('js-115')
        @stack('js-116')
        @yield('js-116')

        @stack('js-128')
        @yield('js-128')

        @stack('js-129')
        @yield('js-129')

        @stack('js-130')
        @yield('js-130')

        @stack('js-131')
        @yield('js-131')

    </body>
</html>
