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
                    <svg id="logoicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 386.32 410.11"><title>animsingle</title><path id="blackpart" className="cls-1" d="M640.6,564.81V195c-66.26-8.3-128.15-21.15-162.54-21.15v156L583.19,435l21.06,21.07V584C613.29,575.87,626.29,569.83,640.6,564.81Z" transform="translate(-478.06 -173.89)"/><path id="orangepart" className="cls-2" d="M663.85,197.26V558.81c36.63-10.64,74.35-18,74.35-37.9V456.06L864.39,329.87v-156C816.52,205.8,738.82,205.42,663.85,197.26Z" transform="translate(-478.06 -173.89)"/></svg>
                  </div>
                    <form class="singn-form">
                    	@csrf

                      <input id="first_name" type="text" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" autocomplete="first_name" autofocus>

                        <!-- Last Name -->
                      <input id="last_name" type="text" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name" autofocus>

                      <!-- Email -->
                      <input id="email" type="email" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="email">

                      <input id="password" type="password" placeholder="Password" name="password" autocomplete="new-password">

                      <input id="password-confirm" type="password" placeholder="Confirm Password" name="confirm_password" autocomplete="new-password">

                      <input id="phone-number" type="number" placeholder="Phone" name="phone_number" value="{{ old('phone_number') }}" autocomplete="phone_number" autofocus>


                      <div class="forget-link">
                         <div class="condition"><input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1"> <label for="styled-checkbox-1"></label> <span>I wish to recieve newsletters, promotions and news from.</span></div>
                      </div>
                      <button class="reg_submit pix-btn">Sign Up</button>
                      <p>Already have an account? <a href="{{ route('login') }}">Sign in</a> now.</p>
                   </form>
                </div>
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
