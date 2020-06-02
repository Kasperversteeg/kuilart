@extends('layouts.desktop')
@php
	$request = Request::query();
	$select = array_key_first($request);
	
	if(array_key_exists($select, $request)){
		$date = $request[$select];
	}

@endphp
@section('content')
	<div class="row">
		<div class="col-12">
			<h1>Bowling <small>{{ $request ?  $date  : '' }}</small></h1>
		</div>
		@if($request)
			<div class="col-12">
				<a href="{{ route('bowling.change', ['date'=> $date, 'go' => 'prev']) }}">vorige</a>
				<a href="{{ route('bowling.change', ['date'=> $date, 'go' => 'next']) }}">volgende</a>
			</div>
		@endif
		
	</div>
	@if(session()->get('success'))
	    <div class="alert alert-success">
	      {{ session()->get('success') }}  
	    </div>
	@endif
	<div class="row">
	@forelse($reservations as $reservation)			
		<div class="col-6 p-0 border">
			<div class="col-md-6">
				<a href="{{ route('bowling.edit', $reservation->id) }}">{{ $reservation->name }}</a>
			</div>
			<div class="col-md-6">
				<a href="{{ route('bowling.index', 'd='.$reservation->date) }}">{{ $reservation->date }}</a>
			</div>
			<div class="col-md-6">
				<p>{{ $reservation->startTime }}</p>
			</div>
			<div class="col-md-6">
				<p>{{ $reservation->endTime }}</p>
			</div>	
		</div>
	@empty
	<p>Geen reserveringen</p>
	@endforelse
	</div>
@endsection