@extends('layouts.mobile')

@section('content')
	<div class="container pt-2">
		
		<h1>Welcome {{ Auth::user()->name }}</h1>
	</div>
@endsection
