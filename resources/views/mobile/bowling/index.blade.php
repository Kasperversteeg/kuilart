@extends('layouts.mobile')
@php
	$request = Request::query();
	$select = array_key_first($request);
	
	if(array_key_exists($select, $request)){
		$date = $request[$select];
	}

@endphp
@section('content')
	<div class="row py-4">
		<div class="col-12">
			<h1>Bowling <small>{{ $request ?  date('d-m-Y', strtotime($date)) : '' }}</small></h1>
		</div>
	</div>
	
	<div class="container bowling-view-container pb-1">
		<div class="row border-bottom">
			<div class="col"></div>
			<div class="col"><p>Baan 1</p></div>
			<div class="col"><p>Baan 2</p></div>
			<div class="col"><p>Baan 3</p></div>
			<div class="col"><p>Baan 4</p></div>
		</div>
		@foreach($rows as $row)
			<div class="row border-bottom bowling-row">
				<div class="col">
					<p>{{ $row->startTime . ' t/m '. $row->endTime}} </p>
				</div>
				@foreach($row->lanes as $reservation)
					@if($reservation == false)
						<div class="col"></div>
					@else
						<div class="col">
							<a href="{{ route('bowling.edit',$reservation->id) }}" > {{ $reservation->name }}</a>
						</div>
					@endif
				@endforeach
			
			</div>
		@endforeach
	</div>
	
@endsection