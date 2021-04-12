@extends('layouts.header')

        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="lostpassword"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">

                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            
                            <section class="login_content">
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                            <h1>Password Reset</h1>
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                @if ($errors->has('email'))
                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                @endif
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"/>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-default submit">Send Password Reset Link</button>
                                <a class="reset_pass" href="{{route('login')}}">Login</a>
                            </div>

                            <div class="clearfix"></div>

                        </form>
                    </section>

                        </div>
                    </div>
                </div>
            </div>
        </div>
