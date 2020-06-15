@extends('layouts.desktop')

@php
	$request = Request::query();
	$select = array_key_first($request);
	
	if(array_key_exists($select, $request)){
		$date = $request[$select];
	}

@endphp

@include('desktop.components.submenu-bowling')
@section('title')
	<h1 class="pb-4">Bowling <small>{{ $request ?  date('d-m-Y', strtotime($date)) : '' }}</small></h1>
@endsection
@section('content')

	<div class="container bowling-view-container py-4" id="bowling-container">
		@if(session()->has('succes'))
		    <div class="alert alert-success">
		        {{ session()->get('succes') }}
		    </div>
		@endif
		<div class="row border-bottom">
			<div class="col d-flex justify-content-center"></div>
			<div class="col d-flex justify-content-center"><p>Baan 1</p></div>
			<div class="col d-flex justify-content-center"><p>Baan 2</p></div>
			<div class="col d-flex justify-content-center"><p>Baan 3</p></div>
			<div class="col d-flex justify-content-center"><p>Baan 4</p></div>
		</div>
		@foreach($rows as $row)
			<div class="row border-bottom bowling-row">
				<div class="col d-flex justify-content-center align-items-center">
					<p class=mb-0>{{ $row->startTime . ' t/m '. $row->endTime}} </p>
				</div>
				@foreach($row->lanes as $lane => $reservation)
					@if($reservation == false)
						<div class="col empty-slot" id="{{ $lane.'-'.$row->startTime }}"></div>
					@else
						<div class="col full-slot d-flex justify-content-center align-items-center">
							<a href="#" @click="editBowling({{ $reservation->id }})" > {{ $reservation->name }}</a>
						</div>
					@endif
				@endforeach
			
			</div>
		@endforeach
	</div>

	<add reservation-type="BWL" title='Voeg bowlingbaan reservering toe' @open='showModal'></add>
@endsection