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
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="{{ asset('dist/css/style.css') }}" rel="stylesheet" type="text/css">
	</head>
<body>
	<div class="header-area">
		{{-- <a href="{{ url()->previous() }}" class="fa fa-long-arrow-left"></a> --}}
		<h1>Frequently Asked Questions & Help</h1>
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