<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

      <meta http-equiv="X-UA-Compatible" content="IE=edge">

      <title>Signin — Dollar Business Leads</title>

      <meta name="msapplication-TileColor" content="#fa7070">

      <meta name="theme-color" content="#fa7070">

      <link rel="stylesheet" href="{{ asset('dependencies/bootstrap/css/bootstrap.min.css') }}" type="text/css">

      <link rel="stylesheet" href="https://dollarbusinessleads.com/wp-content/themes/dbltheme/dist/css/main.css?ver=5.3.2" type="text/css">

      <style type="text/css">

        .signin-from-wrapper .signin-from-inner {
            position: relative;
            top: 46% !important;
        }
        section.signin.signup {
            height: auto !important;
        }

        #logoicon {
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
      <div id="main_content">
         <header class="site-header header-dark header_trans-fixed" data-top="992">
            <div class="container">
               <div class="header-inner">
                  <div class="site-mobile-logo"><a href="login" class="logo"><img src="assets/img/logocolored.png" alt="site logo" class="main-logo"> <img src="assets/img/logocolored.png" alt="site logo" class="sticky-logo"></a></div>
                  <div class="d-none toggle-menu"><span class="bar"></span> <span class="bar"></span> <span class="bar"></span></div>
                  <nav class="site-nav nav-dark">
                     <div class="close-menu"><span>Close</span> <i class="ei ei-icon_close"></i></div>
                     <div class="site-logo"><a href="login" class="logo"><img src="assets/img/logocolored.png" alt="site logo" class="main-logo"> <img src="assets/img/logocolored.png" alt="site logo" class="sticky-logo"></a></div>
                     <div class="d-none menu-wrapper" data-top="992">
                        <ul class="site-main-menu">

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

                            @if (\Request::is('password/reset'))
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

        @if (\Request::is('password/reset'))
        <main>
            @yield('auth.passwords.email')
        </main>
        @endif

    </div>

    <script src="{{ asset('dependencies/jquery/jquery.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
            var phone_number = $("input[name='phone_number']").val();

            $("#logoicon").css("display", "block");

            $.ajax({
                url: "{{ route('post_register') }}",
                type:'POST',
                data: {_token:_token, first_name:first_name, last_name:last_name, email:email, password:password, confirm_password:confirm_password, phone_number:phone_number},
                error: function(response){
                  console.log(response);
                },
                success: function(data) {
                  console.log(data);

                    if($.isEmptyObject(data.error)){
                      console.log(data);

                      if(data.exists){

                          swal("Error", "This email already exists", "error");

                      }else{

                        swal({
                            title: "Success",
                            text: "Registration Done Successfully",
                            type: "success",
                            timer: 2000
                        }).then(function() {
                            window.location.href = "{{ route('login') }}";
                        });

                      }

                    }else{
                      console.log(data.error);

                        printErrorMsg(data.error);
                    }
                   $('#logoicon').css('display', 'none');

                }
            });

        });
        @endif

       @if (\Request::is('login'))

        $(".login_submit").click(function(e){
            e.preventDefault();

            $("#logoicon").css("display", "block");

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
                      swal({
                          title: "Success",
                          text: "Logged In Successfully",
                          type: "success",
                          timer: 2000
                      }).then(function() {
                        window.location.href = "{{ route('home') }}";
                      });

                    }else{
                      console.log(data.error);
                       printErrorMsg(data.error);
                    }

                    $("#logoicon").css("display", "none");

                }
            });

        });
@endif

        function printErrorMsg (msg) {

            $.each( msg, function( key, value ) {

              if (key == 'first_name') {

                swal("Error", ""+value+"", "error");

              }else if (key == 'last_name') {

                swal("Error", ""+value+"", "error");

              }else if (key == 'email') {

                swal("Error", ""+value+"", "error");

              }else if (key == 'confirm_password') {

                swal("Error", ""+value+"", "error");

              }else if (key == 'password') {

                 swal("Error", ""+value+"", "error");

              }else if (key == 'phone_number') {

                 swal("Error", ""+value+"", "error");

              }else if (key == 'wrong-data') {

                 swal("Error", value, "error");

              }

            });
        }

    });

</script>

</body>
</html>
