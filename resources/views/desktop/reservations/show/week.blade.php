@extends('layouts.desktop')
@section('content')
	
	<h2 class="pt-4">Reserveringen voor Week: {{__($week) }}</h2>
	<h3> Van {{ __($firstDay) }} t/m {{ $lastDay }}</h3>

	<a class="btn btn-primary" href="reservations/create">Create reservation</a>

	{{-- show reservations --}}
	

	<div class="row" id="week-view">
		@foreach($dates as $date)
			<div class="col-md border">
				<p>{{ ucfirst($date->day) }}</p>
				<p>{{ $date->date }}</p>
				<div id="reservation" class="pt-4">
					<div class="row border"> 
						@forelse ($date->reservations as $reservation)
						<div class="col-sm-8">		
							<a href="{{ route('reservations.edit',$reservation->id)}} ">{{$reservation->name}}</a>
							<p>{{ $reservation->date }}</p>
						</div>
						@empty
						<p>nothing to show here</p>
						@endforelse
					</div>
				</div>
			</div>
		@endforeach		
	</div>


@endsection