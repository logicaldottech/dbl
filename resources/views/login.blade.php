<!-- The @yield directive also accepts a default value as its second parameter.
 This value will be rendered if the section being yielded is undefined:

@yield('content', View::make('view.name')) -->

<!-- Blade {{ }} statements are automatically sent through PHP's htmlspecialchars
 function to prevent XSS attacks. -->

@extends('layouts.header')

@section('login')
<section class="signin">
    <div class="container">
       <div class="row">
          <div class="col-lg-7">
             <div class="signin-from-wrapper">
                <div class="signin-from-inner">
                   <h2 class="title">Sign In</h2>
                   <p></p>

                   <div id="spin-area-login">
                  </div>
                    <form id="login_form" class="singn-form">
                       {{ csrf_field() }}

                      <input id="email" type="text" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                       <input id="password" type="password" placeholder="Password" name="password" autocomplete="current-password">

                      <div class="forget-link">

                         @if (Route::has('password.reset'))
                            <a class="btn btn-link" href="{{ route('password.reset') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                      </div>
                      <button class="login_submit pix-btn">Sign In</button>
                      <p>Don’t have any account? <a href="{{ route('register') }}">Sign up</a> now.</p>
                   </form>
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="signin-banner"><img src="media/animated/lock.png" alt="" class="image-one wow pixFadeDown"> <img src="media/animated/lock2.png" alt="" class="image-two wow pixFadeUp"></div>
 </section>
@endsection
