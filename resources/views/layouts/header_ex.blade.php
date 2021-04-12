<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">




      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Signin — Software, App, SaaS landing HTML Template</title>
      <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/fav/apple-touch-icon.png') }}">
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/fav/favicon-32x32.png') }}">
      <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/fav/favicon-16x16.png') }}">
      <link rel="mask-icon" href="{{ asset('assets/img/fav/safari-pinned-tab.svg') }}" color="#fa7070">
      <meta name="msapplication-TileColor" content="#fa7070">
      <meta name="theme-color" content="#fa7070">
      <link rel="stylesheet" href="{{ asset('dependencies/bootstrap/css/bootstrap.min.css') }}" type="text/css">
      <link rel="stylesheet" href="{{ asset('dependencies/fontawesome/css/all.min.css') }}" type="text/css">
      <link rel="stylesheet" href="{{ asset('dependencies/swiper/css/swiper.min.css') }}" type="text/css">
      <link rel="stylesheet" href="{{ asset('dependencies/wow/css/animate.css') }}" type="text/css">
      <link rel="stylesheet" href="{{ asset('dependencies/magnific-popup/css/magnific-popup.css') }}" type="text/css">
      <link rel="stylesheet" href="{{ asset('dependencies/components-elegant-icons/css/elegant-icons.min.css') }}" type="text/css">
      <link rel="stylesheet" href="{{ asset('dependencies/simple-line-icons/css/simple-line-icons.css') }}" type="text/css">
      <!--link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" type="text/css"-->
      <link rel="stylesheet" href="https://dollarbusinessleads.com/wp-content/themes/dbltheme/dist/css/main.css?ver=5.3.2" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800" rel="stylesheet">
      <style type="text/css">

        span.email-error, span.pass-error, span.cpass-error, span.fname-error, span.lname-error {
            color: red;
            font-weight: 600;
            position: relative;
            bottom: 22px;
            left: 27px;
        }
        .signin-from-wrapper .signin-from-inner {
            position: relative;
            top: 46% !important;
        }
        section.signin.signup {
            height: auto !important;
        }

        .success-msg{
            color: green;
            font-weight: 600;
            position: relative;
            bottom: 22px;
            left: 27px;
        }

        #cover-spin {
          position: fixed;
          left: 50%;
          top: 60%;
          width: 75px;
          overflow: visible;
          margin: 0 auto;
          display:none;
      }
      </style>

</head>
<body>
  <input type="hidden" id="APP_URL" value="{{url('/')}}"/>

    <div id="app">
        <a href="#main_content" data-type="section-switch" class="return-to-top"><i class="fa fa-chevron-up"></i></a>
      <div class="page-loader">
         <div class="loader">
            <div class="blobs">
               <div class="blob-center"></div>
               <div class="blob"></div>
               <div class="blob"></div>
               <div class="blob"></div>
               <div class="blob"></div>
               <div class="blob"></div>
               <div class="blob"></div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
               <defs>
                  <filter id="goo">
                     <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"/>
                     <feColorMatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo"/>
                     <feBlend in="SourceGraphic" in2="goo"/>
                  </filter>
               </defs>
            </svg>
         </div>
      </div>
      <div id="main_content">
         <header class="site-header header-dark header_trans-fixed" data-top="992">
            <div class="container">
               <div class="header-inner">
                  <div class="site-mobile-logo"><a href="login" class="logo"><img src="assets/img/logocolored.png" alt="site logo" class="main-logo"> <img src="assets/img/logocolored.png" alt="site logo" class="sticky-logo"></a></div>
                  <div class="toggle-menu"><span class="bar"></span> <span class="bar"></span> <span class="bar"></span></div>
                  <nav class="site-nav nav-dark">
                     <div class="close-menu"><span>Close</span> <i class="ei ei-icon_close"></i></div>
                     <div class="site-logo"><a href="login" class="logo"><img src="assets/img/logocolored.png" alt="site logo" class="main-logo"> <img src="assets/img/logocolored.png" alt="site logo" class="sticky-logo"></a></div>
                     <div class="menu-wrapper" data-top="992">
                        <ul class="site-main-menu">
                           <li class="menu-item-has-children">
                              <a href="index.html">Home</a>
                              <ul class="sub-menu">
                                 <li><a href="index.html">Home One</a></li>
                                 <li><a href="index-two.html">Home Two</a></li>
                                 <li><a href="index-three.html">Home Three</a></li>
                                 <li><a href="index-four.html">Home Four</a></li>
                                 <li><a href="index-five.html">Home Five</a></li>
                                 <li><a href="index-six.html">Home Six</a></li>
                              </ul>
                           </li>
                           <li><a href="about.html">About</a></li>
                           <li class="menu-item-has-children">
                              <a href="blog.html">Blog</a>
                              <ul class="sub-menu">
                                 <li><a href="blog.html">Blog Standard</a></li>
                                 <li><a href="blog-grid.html">Blog Grid</a></li>
                                 <li><a href="blog-single.html">Blog Single</a></li>
                              </ul>
                           </li>
                           <li class="menu-item-has-children">
                              <a href="#">Pages</a>
                              <ul class="sub-menu">
                                 <li><a href="about.html">About</a></li>
                                 <li><a href="service.html">Service</a></li>
                                 <li><a href="team.html">Our Team</a></li>
                                 <li><a href="pricing.html">Pricing</a></li>
                                 <li class="menu-item-has-children">
                                    <a href="portfolio.html">Portfolio</a>
                                    <ul class="sub-menu">
                                       <li><a href="portfolio-one.html">Style One</a></li>
                                       <li><a href="portfolio-two.html">Style Two</a></li>
                                       <li><a href="portfolio-three.html">Style Three</a></li>
                                       <li><a href="portfolio-single.html">Portfolio Single</a></li>
                                    </ul>
                                 </li>
                                 <li><a href="faq.html">Faq's</a></li>
                                 <li><a href="error.html">Error 404</a></li>
                                 <li><a href="signin.html">Sing In</a></li>
                                 <li><a href="signup.html">Sing Up</a></li>
                              </ul>
                           </li>
                           <li><a href="contact.html">Contact</a></li>

                           <li class="menu-item-has-children">
                                @guest
                             @if (\Request::is('login'))
                            <div class="nav-right">
                                <a href="{{ route('register') }}" class="nav-btn">Free Sign Up</a>
                             </div>
                            @endif

                             @if (\Request::is('register'))
                            <div class="nav-right">
                                <a href="{{ route('login') }}" class="nav-btn">Login</a>
                             </div>
                            @endif
                          </li>
                        @else
                            <li class="menu-item-has-children">
                                <a href="#">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li><a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                      </ul>
                  </div>
                </nav>
               </div>
            </div>
         </header>
       </div>
         @if (\Request::is('register'))

            @yield('register')

        @endif

        @if (\Request::is('login'))
        <main>
            @yield('login')
        </main>
        @endif

    </div>

    <script src="{{ asset('dependencies/popper.js/popper.min.js') }}"></script>
    <script src="{{ asset('dependencies/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('dependencies/bootstrap/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('dependencies/swiper/js/swiper.min.js') }}"></script>

    <script src="{{ asset('dependencies/jquery.appear/jquery.appear.js') }}"></script>

    <script src="{{ asset('dependencies/wow/js/wow.min.js') }}"></script>

    <script src="{{ asset('dependencies/countUp.js/countUp.min.js') }}"></script>

    <script src="{{ asset('dependencies/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <script src="{{ asset('dependencies/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>

    <script src="{{ asset('dependencies/jquery.parallax-scroll/js/jquery.parallax-scroll.js') }}"></script>

    <script src="{{ asset('dependencies/magnific-popup/js/jquery.magnific-popup.min.js') }}"></script>

    <script src="{{ asset('dependencies/gmap3/js/gmap3.min.js') }}"></script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDk2HrmqE4sWSei0XdKGbOMOHN3Mm2Bf-M&#038;ver=2.1.6"></script>

    <script src="{{ asset('assets/js/header.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script type="text/javascript">

    $(document).ready(function() {
       @if (\Request::is('register'))
        $(".reg_submit").click(function(e){
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            var first_name = $("input[name='first_name']").val();
            var last_name = $("input[name='last_name']").val();
            var email = $("input[name='email']").val();
            var password = $("input[name='password']").val();
            var confirm_password = $("input[name='confirm_password']").val();

            $("#cover-spin").css("display", "block");

            $.ajax({
                url: "{{ route('post_register') }}",
                type:'POST',
                data: {_token:_token, first_name:first_name, last_name:last_name, email:email, password:password, confirm_password:confirm_password},
                error: function(response){
                  console.log(response);
                },
                success: function(data) {
                  console.log(data);

                    if($.isEmptyObject(data.error)){
                      console.log(data);

                      if(data.exists){
                          $(".fname-error").css('display','none');
                          $(".lname-error").css('display','none');
                          $(".email-error").css('display','none');
                          $(".pass-error").css('display','none');
                          $(".success-msg").css('display','none');
                          $(".cpass-error").css('display','block');

                          $(".cpass-error").html('This email already exists');

                      }else{

                          $(".fname-error").css('display','none');
                          $(".lname-error").css('display','none');
                          $(".email-error").css('display','none');
                          $(".pass-error").css('display','none');
                          $(".cpass-error").css('display','none');
                           $(".success-msg").html('');
                           $(".success-msg").css('display','block');
                           $(".success-msg").append(data.success);
                      }

                    }else{
                      console.log(data.error);
                      $(".success-msg").css('display','none');

                        printErrorMsg(data.error);
                    }
                   $('#cover-spin').css('display', 'none');

                }
            });

        });
        @endif

       @if (\Request::is('login'))

        $(".login_submit").click(function(e){
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            var email = $("input[name='email']").val();
            var password = $("input[name='password']").val();

            $.ajax({
                url: "{{ route('post_login') }}",
                type:'POST',
                data: {_token:_token, email:email, password:password },
                success: function(data) {
                    if($.isEmptyObject(data.error)){
                      console.log(data);
                      $(".print-success-msg").find("ul").html('');
                      window.location.href = "{{ route('home') }}";

                    }else{
                      console.log(data.error);
                        $(".print-error-msg").find("ul").html('');
                        $(".print-error-msg").css('display','block');
                       printErrorMsg(data.error);
                        // $(".print-error-msg").find("ul").append('<li>'+data.error+'</li>');

                        // $(".print-error-msg").append(data.error.email);


                    }
                }
            });

        });
@endif

        function printErrorMsg (msg) {
            $(".email-error").html('');
            $(".email-error").css('display','none');

            $(".pass-error").html('');
            $(".pass-error").css('display','none');

             $(".cpass-error").html('');
            $(".cpass-error").css('display','none');

             $(".fname-error").html('');
            $(".fname-error").css('display','none');

             $(".lname-error").html('');
            $(".lname-error").css('display','none');

            $.each( msg, function( key, value ) {
              if (key == 'email') {

                $(".email-error").css('display','block');

                $(".email-error").append(value);

              }

              if (key == 'password') {

                $(".pass-error").css('display','block');

                $(".pass-error").append(value);

              }

               if (key == 'confirm_password') {

                $(".cpass-error").css('display','block');

                $(".cpass-error").append(value);

              }

              if (key == 'first_name') {

                $(".fname-error").css('display','block');

                $(".fname-error").append(value);

              }

              if (key == 'last_name') {

                $(".lname-error").css('display','block');

                $(".lname-error").append(value);

              }

               if (key == 'wrong-data') {

                $(".pass-error").css('display','block');

                $(".pass-error").append(value);

              }
                // $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }

    });

</script>

</body>
</html>
