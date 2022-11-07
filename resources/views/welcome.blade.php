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
                text-align: center;
            }

            .sp-logo-wrap a{
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

           .image-container{
                margin-top: 60px;
                margin-bottom: 30px;
           }

           .image-container img{
            height: 80vh;
           }

           .brand-img{
                max-height: 80px;
                max-width: 100px;
           }

           .image-text-bottom-left{
                padding-left: 120px;
                padding-right: 180px;
                text-align: center;
           }

           .image-text-bottom-left h4{
                color: white;
           }

           @media (max-width:414px)  {
                .image-text-bottom-left h4{
                    font-size: 14px;
                }
                .image-text-bottom-left{
                    padding-right: 45px;
                    padding-left: 10px;
                    width: 70%;
                }
                .image-container{
                    margin-top: 70px;
                }
                .brand-text{
                    margin-left: 40px;
                }

                .auth-actions > a{
                    margin: 6px;
                }

                .sp-logo-wrap a > img, .sp-logo-wrap a > span{
                    margin-left: 2px !important;
                }
           }

           @media (max-width:320px)  {
                .image-text-bottom-left h4{
                    font-size: 10px;
                    margin-right: 10px;
                    margin-left: -26px;
                }

                .image-container{
                    display: flex;
                    justify-content:"center"
                    
                }

                .image-container img{
                    width: 100%;
                }

                .sp-logo-wrap a > img, .sp-logo-wrap a > span{
                    margin-left: 2px !important;
                }
           }


        </style>
       @if (isset($app_settings['txt_school_home_color']) && (isset($app_settings['txt_website_text_title']) || isset($app_settings['txt_official_website']) || isset($app_settings['txt_portal_contact_email']) || isset($app_settings['txt_portal_contact_phone'])))
            <style type="text/css">                
                /*start styling header top text*/
                    #txt_school_home_color{
                        height: 80px;
                    }
                    #file_landing_page_picture, #file_icon_picture {
                        margin-top: 70px;
                    }
                    @media screen and (min-width: 820px){
                        #txt_portal_contact_email, #txt_portal_contact_phone{
                            text-align: right;
                        }
                        #txt_school_home_color{
                            height: auto;
                        }
                        #file_landing_page_picture, #file_icon_picture {
                            margin-top: 50px;
                        }
                    }  
                /*stop styling header top text*/
            </style>
        @endif



	</head>
	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->

        <div class="wrapper pa-0">    
            <header class="sp-header">
                @if (isset($app_settings['txt_school_home_color']) && (isset($app_settings['txt_website_text_title']) || isset($app_settings['txt_official_website']) || isset($app_settings['txt_portal_contact_email']) || isset($app_settings['txt_portal_contact_phone'])))
                    <div class="col-xs-12" style="background-color: {!! $app_settings['txt_school_home_color'] ?? '' !!}; padding-bottom: 10px; height: auto; width: 100%; position: fixed;">
                        @if (isset($app_settings['txt_official_website']))
                            <div class="col-sm-4 pull-left pt-5">
                                <strong> 
                                    <a class="inline-block ml-10" target="_blank" style="color: {!! $app_settings['txt_school_text_color'] ?? '#000000' !!};" href="{{ ($app_settings['txt_official_website']) ? $app_settings['txt_official_website'] : ''}}" title="{{ ($app_settings['txt_official_website']) ? 'Visit '.$app_settings['txt_official_website'] : '' }}">
                                       {{ (isset($app_settings['txt_website_text_title'])) ? $app_settings['txt_website_text_title'] : 'Go to School Website' }} 
                                    </a>
                                </strong> 
                            </div>
                        @endif
                        @if (isset($app_settings['txt_portal_contact_email']) || isset($app_settings['txt_portal_contact_phone']))
                            <div class="col-xs-12 col-sm-8 pull-right text-left pt-5" style="color: {!! $app_settings['txt_school_text_color'] ?? '#000000' !!};">
                                @if (isset($app_settings['txt_portal_contact_email']))
                                    <div class="col-xs-12 col-sm-8 pl-10" id="txt_portal_contact_email">
                                        <strong>Email : </strong>
                                        <a class="inline-block" href="mailto:{{ $app_settings['txt_official_website'] }}" title="{{ $app_settings['txt_portal_contact_email'] }}" style="color: {!! $app_settings['txt_school_text_color'] ?? '#000000' !!};"> 
                                            {{ strtolower($app_settings['txt_portal_contact_email']) }} 
                                        </a>
                                    </div>
                                @endif
                                @if (isset($app_settings['txt_portal_contact_phone']))
                                    <div class="col-xs-12 col-sm-4 pl-10" id="txt_portal_contact_phone">
                                        <strong class="">Tel : </strong>
                                        <a class="inline-block" href="tel:{{ $app_settings['txt_portal_contact_phone'] }}" title="{{ $app_settings['txt_portal_contact_phone'] }}" style="color: {!! $app_settings['txt_school_text_color'] ?? '#000000' !!};">
                                            {{ strtolower($app_settings['txt_portal_contact_phone']) }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
                <div class="sp-logo-wrap pull-left" id="file_icon_picture" style="width: auto;">
                    <a href="/">
                        @if (isset($app_settings['file_icon_picture']))
                            <img class="brand-img mr-10" style="z-index: -1;" src="{{ asset($app_settings['file_icon_picture']) }}" alt="brand"/><br>
                        @endif
                        <span class="brand-text text-left pull-left" style="width: auto">{!! $app_settings['txt_long_name'] ?? '' !!}</span>
                    </a>
                </div>
                <div class="clearfix"></div>
            </header>



            <div class="page-wrapper ma-0">
                <div class="container-fluid">
                    <div class="row" id="file_landing_page_picture">
                        <div class="col-lg-8">
                            <div class="image-container" style="">
                                @if (isset($app_settings['file_landing_page_picture']))
                                <img class='' src="{{ asset($app_settings['file_landing_page_picture']) }}"  style="max-width:80vw;width:85%;height:100%"/>
                                <div class="image-text-bottom-left"><h4 class="">{!! $app_settings['txt_welcome_text'] ?? '' !!}</h4></div>
                                @endif
                            </div>

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
                                            <div class="col-lg-12 text-center mt-20 auth-actions">
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
                            
                           @if (config('lmsvendors.sophira'))
                                  {{ date('Y') }} &copy;  Sophira by <a href="#" target="_blank">SocketSystems Software Ltd</a>
                           @elseif (config('lmsvendors.foresight'))
                                 {{ date('Y') }} &copy;   ForesightLMS by <a href="http://etechcompletesolutions.com" target="_blank">E-TECH</a>
                           @else
                                 {{ date('Y') }} &copy;   ScolaLMS by <a href="http://hasob.ng" target="_blank">HASOB</a>
                           @endif
                            
                            
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

