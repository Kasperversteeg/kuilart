@extends('layouts.desktop')

@php
	$request = Request::query();
	$select = array_key_first($request);
	
	if(array_key_exists($select, $request)){
		$date = $request[$select];
	}

@endphp

@include('desktop.components.submenu-bowling', [
		'title' => 'Bowling',
		'showing' =>  date('d-m-Y', strtotime($date)),
		'period' => '',

])
@section('content')
	<div class="container bowling-view-container py-4" id="bowling-container">
		@if(session()->has('succes'))
		    <div class="alert alert-success">
		        {{ session()->get('succes') }}
		    </div>
		@endif
		<div class="row border-bottom">
			<div class="col"></div>
			<div class="col bwl-header"><p>Baan 1</p></div>
			<div class="col bwl-header"><p>Baan 2</p></div>
			<div class="col bwl-header"><p>Baan 3</p></div>
			<div class="col bwl-header"><p>Baan 4</p></div>
		</div>
		@foreach($rows as $row)
			<div class="row border-bottom bowling-row">
				<div class="col d-flex justify-content-center align-items-center">
					<p class=mb-0>{{ $row->startTime . ' t/m '. $row->endTime}} </p>
				</div>
				@foreach($row->lanes as $lane => $reservation)
					@if($reservation == false)
						<div class="col p-2">
							<div class="py-1 empty-slot d-flex align-items-center justify-content-center" id="{{ $lane.'-'.$row->startTime }}">
								<x-icon icon="plusje" height='20px' width="20px" />
							</div>
						</div>
					@else
						<div class="col p-2">
							<div class="full-slot d-flex justify-content-center align-items-center">
								<a class="bwl-link" href="#" @click="editBowling({{ $reservation->id }})" > {{ $reservation->name }}</a>
							</div>
						</div>
					@endif
				@endforeach
			
			</div>
		@endforeach
	</div>

	<add reservation-type="BWL" title='Voeg bowlingbaan reservering toe' @open='showModal'></add>
@endsection