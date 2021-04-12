@extends('layouts.app')


@section('content')
		<h2>Purchase Credits Amount</h2>
		<form method="post" action="{{route('credit')}}">
			@csrf
			<input type="hidden" name="action" value="purchase">
			<input type="hidden" name="type" value="credit">
			<input type="number" name="credit" class="credit">
			<input type="submit" name="sub" value="Credit">
		</form>
		@endsection
