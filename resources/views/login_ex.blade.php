@extends('layouts.header')

@section('login')
<section class="signin">
    <div class="container">
       <div class="row">
          <div class="col-lg-7">
             <div class="signin-from-wrapper">
                <div class="signin-from-inner">
                   <h2 class="title">Sign In</h2>
                   <p>Get quick access to all WordPress premium themes with extensions or/and SP Page Builder Pro with support!</p>
                   <!-- <form method="POST" action="{{ route('login') }}" class="singn-form"> -->

                     <div class="alert alert-success print-success-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <form id="login_form" class="singn-form">
                       {{ csrf_field() }}
                      <!-- <input type="text" placeholder="Email"> -->

                      <input id="email" type="text" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                      <span style="display: none;" class="email-error"></span>

                       <input id="password" type="password" placeholder="Password" name="password" autocomplete="current-password">

                       <span style="display: none;" class="pass-error"></span>

                      <div class="forget-link">
                        <!--  <div class="condition"><input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1"> <label for="styled-checkbox-1"></label> <span>Remember Me</span></div>
                         <a href="#" class="forget">Forget Password</a> -->

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
                <ul class="animate-ball">
                   <li class="ball"></li>
                   <li class="ball"></li>
                   <li class="ball"></li>
                   <li class="ball"></li>
                   <li class="ball"></li>
                </ul>
             </div>
          </div>
       </div>
    </div>
    <div class="signin-banner"><img src="media/animated/lock.png" alt="" class="image-one wow pixFadeDown"> <img src="media/animated/lock2.png" alt="" class="image-two wow pixFadeUp"></div>
 </section>
@endsection
