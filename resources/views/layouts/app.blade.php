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
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
                
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

        {{-- Sweet Alert --}}
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
        <script type="text/javascript"> 
            let current_date = new Date();
                let timezone = parseInt(-current_date.getTimezoneOffset()/60);
                if(timezone > 0){
                    document.cookie = "myTimezone = GMT+"+timezone;
                }
                if(timezone < 0){
                    document.cookie = "myTimezone = GMT"+timezone;
                }
                if(timezone == 0){
                    document.cookie = "myTimezone = GMT"; 
                }
        </script>
        
        @yield('cdn_scripts')
        
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
            @media (min-width: 768px) {
                .modal-xl {
                    width: 90%;
                max-width:1200px;
                }
            }

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

            /* ALL LOADERS */

        .loader{
        width: 100px;
        height: 100px;
        border-radius: 100%;
        position:absolute;
        top:50%;
        left:50%;
        margin:0px 0px 0px 0px;
        z-index: 5000000;
        }

        /*  .loader{
        width: 100px;
        height: 100px;
        border-radius: 100%;
        position: relative;
        margin: 0 auto;
        } */

        /* LOADER 1 */

        #loader-1:before, #loader-1:after{
        content: "";
        position: absolute;
        top: -10px;
        left: -10px;
        width: 100%;
        height: 100%;
        border-radius: 100%;
        border: 10px solid transparent;
        border-top-color: #3498db;
        }

        #loader-1:before{
        z-index: 100;
        animation: spin 1s infinite;
        }

        #loader-1:after{
        border: 10px solid #ccc;
        }

        @keyframes spin{
        0%{
            -webkit-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100%{
            -webkit-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
        }

        .offline-flag{
            color: red;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #offline, .offline{
            display: none;
        }

        .brand-img{
            max-height: 80px;
            max-width: 100px;
        }

        .side-bar-area{
            margin-bottom: 50px;
        }

        table.table-bordered.dataTable tbody th, table.table-bordered.dataTable tbody td{
            word-break: break-word;
        }

        .panel-title{
            padding-left: 10px;
        }

        .navbar.navbar-inverse.navbar-fixed-top .nav-header .logo-wrap .brand-img{
            width: 33px;
            height: 30px;
            margin-right: 5px;
        }

        .brand-img{
            margin-left: -10px;
        }
        .capture-area{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .capture-area button{
            margin-top: 10px;
        }
        .capture-error{
            color: red;
            text-align: center;
            font-size: 13px;
        }

        .capture-error a{
            color: #3fc0cc;
        }

        video {
            border: 1px solid #ccc;
            width: 600px;
            height: 400px
        }
        .hide-cont{
            display: none;
        }
        .student-info{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .student-info img{
            border-radius: 50%;
            height: 100px;
            width: 100px;
            margin-right: 10px;
        }

        .modal-body.scroll{
            max-height: 600px !important;
            height: auto;
            overflow-x: hidden;
            overflow-y: auto;
        }
        /* width */
        div.scroll::-webkit-scrollbar {
          width: 8px;
        }

        /* Track */
        div.scroll::-webkit-scrollbar-track {
          background: #f1f1f1;
        }

        /* Handle */
        div.scroll::-webkit-scrollbar-thumb {
          background: #888;
          border-radius: 5px;
        }

        /* Handle on hover */
        div.scroll::-webkit-scrollbar-thumb:hover {
          background: #555;
        }
        .header-area{
              display: flex;
              justify-content: center;
              align-items: center;
            }

            body {
              font-family: "Muli", sans-serif;
              background-color: #f0f0f0;
            }

            h1 {
              margin: 50px 0 30px;
              text-align: center;
            }

            .faq-container {
              max-width: 600px;
              margin: 0 auto;
            }

            .faq {
              background-color: transparent;
              border: 1px solid #9fa4a8;
              border-radius: 10px;
              margin: 20px 0;
              padding: 30px;
              position: relative;
              overflow: hidden;
              transition: 0.3 ease;
            }

            .faq.active {
              background-color: #fff;
              box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.1);
            }

            .faq.active::before,
            .faq.active::after {
              content: "\f075";
              font-family: "Font Awesome 5 Free";
              color: #2ecc71;
              font-size: 7rem;
              position: absolute;
              opacity: 0.2;
              top: 20px;
              left: 20px;
              z-index: 0;
            }

            .faq.active::before {
              color: #3498db;
              top: -10px;
              left: -30px;
              transform: rotateY(180deg);
            }

            .faq-title {
              margin: 0 35px 0 0;
            }

            .faq-text {
              display: none;
              margin: 30px 0 0;
              color: black;
            }

            .faq.active .faq-text {
              display: block;
            }

            .faq-toggle {
              background-color: transparent;
              border: 0;
              border-radius: 50%;
              cursor: pointer;
              display: flex;
              align-items: center;
              justify-content: center;
              font-size: 16px;
              padding: 0;
              position: absolute;
              top: 30px;
              right: 30px;
              height: 30px;
              width: 30px;
            }

            .faq-toggle:focus {
              outline: 0;
            }

            .faq-toggle .fa-times {
              display: none;
            }

            .faq.active .faq-toggle .fa-times {
              color: #fff;
              display: block;
            }

            .faq.active .faq-toggle .fa-chevron-down {
              display: none;
            }

            .faq.active .faq-toggle {
              background-color: #9fa4a8;
            }

            .pagination > li.active > a, .pagination > li.active > span{
              background-color: #337ab7 !important;
            }

            .pagination > li.active > a, .pagination > li.active > span:hover{
              background-color: #8BC34A !important;
            }
          
            .analytic-table td {
                border: 1px solid rgb(197, 186, 228);    
            }
            .analytic-table-color{
                background-color: rgb(67, 27, 175);
                color: rgb(255,255,255);
                align-content: center;
                text-align: center;
                vertical-align: middle;
            }

            .grade-container td input{
                width: 75px;
            }
            .mass-grading-tbl td input{
                width: 80px;
            }
            .btn-primary-alt{
                background: #878787;
                height: 34px;
            }
    
        /*.fixed-sidebar-left{
            top: 110px !important;
        }

        .navbar.navbar-inverse.navbar-fixed-top .nav-header{
            overflow: inherit !important;
        }*/

        

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
                        {{ date('Y') }} &copy; ScolaLMS by <a href="http://hasob.ng" target="_blank">HASOB</a>
                        {{-- {{ date('Y') }} &copy; ForesightLMS by <a href="http://etechcompletesolutions.com" target="_blank">E-TECH</a> --}}
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

        @stack('js-132')
        @yield('js-132')

        @stack('js-133')
        @yield('js-133')

        @stack('js-134')
        @yield('js-134')

        @stack('js-135')
        @yield('js-135')

        @stack('js-136')
        @yield('js-136')
        @stack('js-137')
        @yield('js-137')

    </body>
</html>
