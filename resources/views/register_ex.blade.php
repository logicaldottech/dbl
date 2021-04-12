@extends('layouts.header')

@section('register')
<section class="signin signup">
    <div style="margin-top: 150px;" class="container">
       <div class="row">
          <div class="col-lg-7">
             <div class="signin-from-wrapper">
                <div class="signin-from-inner">
                   <h2 class="title">Signup Now!</h2>
                   <p class="d-none" >With your social network</p>
                   <p></p>
                   <ul class="d-none singup-social">
                      <li><a href="#"><i class="fab fa-facebook-f"></i>Facebook</a></li>
                      <li><a href="#"><i class="far fa-envelope"></i>Gmail</a></li>
                      <li><a href="#"><i class="fab fa-twitter"></i>Twitter</a></li>
                   </ul>
                   <div id="spin-area">
                    <img id="cover-spin" src="{{ asset('media/animated/loader.gif') }}">
                  </div>
                    <form class="singn-form">
                    	@csrf
                      <!-- <input type="text" placeholder="Username"> -->
                      <!-- First Name -->
                      <input id="first_name" type="text" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" autocomplete="first_name" autofocus>
                      <span style="display: none;" class="fname-error"></span>

                        <!-- @error('fname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror -->

                        <!-- Last Name -->
                      <input id="last_name" type="text" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name" autofocus>
                      <span style="display: none;" class="lname-error"></span>


                        <!-- @error('lname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror -->

                        <!-- Email -->
                        <input id="email" type="email" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="email">
                        <span style="display: none;" class="email-error"></span>

                        <!-- @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror -->

                        <input id="password" type="password" placeholder="Password" name="password" autocomplete="new-password">
                        <span style="display: none;" class="pass-error"></span>

                        <!-- @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror -->

                        <input id="password-confirm" type="password" placeholder="Confirm Password" name="confirm_password" autocomplete="new-password">
                      <span style="display: none;" class="cpass-error"></span>
                      <span style="display: none;" class="success-msg"></span>


                         <!-- <input type="text" placeholder="Email"> <input type="password" placeholder="Password"> -->
                      <div class="forget-link">
                         <div class="condition"><input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1"> <label for="styled-checkbox-1"></label> <span>I wish to recieve newsletters, promotions and news from.</span></div>
                      </div>
                      <button class="reg_submit pix-btn">Sign Up</button>
                      <p>Already have an account? <a href="{{ route('login') }}">Sign in</a> now.</p>
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
    <div class="signin-banner signup-banner">
       <div class="animate-image-inner">
          <div class="image-one"><img src="media/animated/signup.png" alt="" class="wow pixFadeLeft"></div>
          <div class="image-two"><img src="media/animated/signup2.png" alt="" class="wow pixFadeRight"></div>
       </div>
    </div>
 </section>
@endsection
