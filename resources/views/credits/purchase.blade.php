@extends('layouts.app')


@section('content')
<div class="main-site-row">

	<div class="container">
		<h2 class="cont-title">Purchase Credits Amount</h2>
			<div id="PaymentForm">
			</div>
			<div class="payment-notes">
			<p>Total Credit Purchased Till Now - {{ $discount_data['total_credits_purchased'] }}</p>
			<p>Price Per Credit - $<span id="price_per_credit">{{$discount_data['price']}}</span></p>
			<p>Discount Level - {{$discount_data['level']}}</p>
			<p>Discount Applicable - {{$discount_data['discount']}}</p>
		</div><!--.payment-notes-->
	</div><!--.container-->
</div><!--.main-site-row-->



		@endsection
