<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>
            {{$app_settings['txt_long_name']??''}}
            @yield('title', config('app.title', 'LMS'))
            @yield('title_prefix')
            Frequently Asked Questions
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">


            <style>
            @import url("https://fonts.googleapis.com/css2?family=Muli&display=swap");

            *{
              box-sizing: border-box;
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

                            <div class="header-area">

                              <h1>Frequently asked questions</h1>
                              </div>
                                <div class="faq-container">
                                @foreach($faqs as $faq)
                                  <div class="faq">
                                    <h3 class="faq-title">{{ $faq->question }}?</h3>
                                    <p class="faq-text">{{ $faq->answer }}</p>
                                    <button class="faq-toggle">
                                      <i class="fas fa-chevron-down"></i>
                                      <i class="fas fa-times"></i>
                                    </button>
                                  </div>
                                @endforeach
                                {{ $faqs->links() }}
                                </div>

                        </div>

                        <div class="col-lg-4">
                            
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
                                            @include("dashboard.partials.side-panel")
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

    <script type="text/javascript">
  const toggles = document.querySelectorAll(".faq-toggle");
  toggles.forEach((toggle) => {
    toggle.addEventListener("click", () => {
      toggle.parentNode.classList.toggle("active");
    });
  });
</script>
  </body>
</html>

<<<<<<< HEAD
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

<style type="text/css">
@import url("https://fonts.googleapis.com/css2?family=Muli&display=swap");

*{
  box-sizing: border-box;
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
</style>

<script type="text/javascript">
	const toggles = document.querySelectorAll(".faq-toggle");
	toggles.forEach((toggle) => {
	  toggle.addEventListener("click", () => {
	    toggle.parentNode.classList.toggle("active");
	  });
	});
</script>	
</body>
</html>
=======
>>>>>>> 2c3d391e8c36444775c94ddcdf8a8fbe827c0325
