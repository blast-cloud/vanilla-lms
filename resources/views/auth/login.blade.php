<!DOCTYPE html>
<html lang="en">
    @php
    $state = '';
    $clientId = env('BIMS_CLIENT_ID');
    if(Session::has('state'))
    {
        $state = Session::get('state');
    }else{
        $length = 32;
        $state = Session::put('state', bin2hex(random_bytes($length/2)));
        $state = Session::get('state');
    }
    @endphp
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>
            {{$app_settings['txt_long_name']??''}}
            @yield('title', config('app.title', 'LMS'))
            @yield('title_prefix')
            Login
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
            }

            .sp-logo-wrap a{
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

           .image-container{
                margin-top: 20px;
                margin-bottom: 30px;
           }

           .brand-img{
                max-height: 80px;
                max-width: 100px;
           }

           .auth-cont{
                margin-top: 50px;
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
                    
                }

                .image-container img{
                    width: 100%;
                }

                .sp-logo-wrap a > img, .sp-logo-wrap a > span{
                    margin-left: 2px !important;
                }
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

                        <div class="col-lg-8 auth-cont">

                            
                            <div class="col-lg-12 text-center">
                                <div class="panel panel-default card-view">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body pt-5" style="">
                                            
                                            <div class="col-lg-12 text-center mt-10">


                                                <form method="post" action="{{ url('/login') }}">
                                                    @csrf
                                
                                                        
                                                        
                                                        <!-- Row -->
                                                        <div class="table-struct full-width ">
                                                            <div class="table-cell vertical-align-middle auth-form-wrap">
                                                                <div class="auth-form  ml-auto mr-auto no-float">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 col-xs-12">
                                                                        
                                                                            <div class="mb-30 text-center">
                                                                            
                                                                                {{--                                                                              
                                                                                @if (isset($app_settings['file_high_res_picture']))
                                                                                    <img src= "{{ asset($app_settings['file_high_res_picture']) }}" style="width:100px;height:100px;" class="user-auth-img">
                                                                                @endif
                                
                                                                                <h3 class="text-center txt-dark mb-10">
                                                                                    {!! $app_settings['txt_long_name'] ?? '' !!}
                                                                                </h3>
                                                                                 --}}
                                                                                <h6 class="text-center nonecase-font txt-grey">
                                                                                    Login {!! $app_settings['txt_app_name'] ?? '' !!}
                                                                                </h6>
                                                                            

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
                                
                                                                                @if ($message = Session::get('success'))
                                                                                <div class="alert alert-success alert-block" style="margin:15px;">
                                                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                                                    <strong>{{ $message }}</strong>
                                                                                </div>
                                                                                @endif
                                
                                
                                                                            </div>
                                
                                                                            <div class="form-group">
                                                                                <label class="pull-left control-label mb-10" for="exampleInputEmail_2">{{ __('E-Mail Address') }}</label>
                                                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                                                @error('email')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                
                                                                            <div class="form-group" style="width:100%">
                                                                                <label class="pull-left control-label mb-10" for="exampleInputpwd_2">Password</label>
                                                                                <a class="capitalize-font txt-primary block mb-10 pull-right font-12" href="{{ route('password.request') }}">forgot password ?</a>
                                                                                <div class="clearfix"></div>
                                                                                <div class="input-group">

                                                                                    <input 
                                                                                    id="password" 
                                                                                    type="password" 
                                                                                    class="form-control 
                                                                                    @error('password') is-invalid @enderror" 
                                                                                    name="password" 
                                                                                    required autocomplete="current-password"
                                                                                    >
                                                                                    <div class="input-group-addon bg-secondary">
                                                                                        <span class="input-group-text">
                    <a href="">
                        <i 
                        class="fa fa-eye-slash toggle_hide_password" 
                        aria-hidden="true" 
                        style="cursor: pointer;" 
                    ></i>
                    </a>
            </span>
                                                                                    </div>
            
                                                                   @error('password')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                    @enderror
                                                                                </div>
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

                                                                            <div class="">
                                                                                <a class="btn btn-primary" role="button" style="border-radius:10px" href="https://bims.tetfund.gov.ng/oauth/authorize?response_type=code&client_id={{$clientId}}&redirect_uri=http://localhost:8000&state={{$state}}">
                                                                                  <div class=""><img src="{{asset('imgs/bims.png')}}" style="width: 80px; height: 35px;" alt=""></div> <div class="" ><span style="color: white">Continue with BIMS</span></div>
                                                                                </a>
                                                                            </div>
                                                                            
                                                                        </div>	
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /Row -->	

                                                    </form>

                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
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
                            {{-- {{ date('Y') }} &copy; ForesightLMS by <a href="http://etechcompletesolutions.com" target="_blank">E-TECH</a> --}}
                            {{ date('Y') }} &copy; ScolaLMS by <a href="http://hasob.ng" target="_blank">HASOB</a>
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

        <!--Javascript for toggle visibility  -->
        <script>
             $(document).ready(function() {
        
                $(".toggle_hide_password").on('click', function(e) {
                    e.preventDefault()

                    // get input group of clicked link
                    const input_group = $(this).closest('.input-group')

                    // find the input, within the input group
                    const input = input_group.find('input.form-control')

                    // find the icon, within the input group
                    const icon = input_group.find('i')

                    // toggle field type
                    input.attr('type', input.attr("type") === "text" ? 'password' : 'text')

                    // toggle icon class
                    icon.toggleClass('fa-eye-slash fa-eye')
                })
        });
        </script>
	</body>
</html>

