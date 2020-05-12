@extends('layouts.app')

@section('content')
	<div class="container pt-2">

		<h1>Welcome {{ Auth::user()->name . ' ' .  $device}} </h1>
		<h2>Het is vandaag {{ ucfirst(__($now))}}</h2>
	</div>
@endsection
