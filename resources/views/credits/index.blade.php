@extends('layouts.app')


@section('content')
  <div class="main-site-row">

    <div class="container">

      @if (session('status'))
      <div class="transaction-alert">
        <div class="alert alert-success" role="alert">
          <span class="alert-close-credit"><i class="fa fa-times" aria-hidden="true"></i></span>
          <h4 class="alert-heading">Trasnsaction Successful!</h4>
          <p>Your transaction was successful. You have successfully purchased new credits.</p>
          <hr>
          <p class="mb-0">Your new credit balance is {{$credits->balance}} </p>
        </div>
      </div>
      @endif

      <div class="credit_index-wrap">
        <div class="currentBalace">
          <h2>Current Balance</h2>
          <h3>{{$credits->balance}}</h3>
        </div>

        <div class="add_credits">
          <a href="{{url('/purchase')}}">Add Credits</a>
        </div>
      </div>
    </div><!--.container-->
</div><!--.main-site-row-->
@endsection
