@extends('layouts.desktop')
@section('content')


	@include('layouts.submenu')
	
	<h2 class="pt-4">{{ $isGroup === true ? 'Groeps' : 'Restaurant'}} reservering voor Week: {{__($week->weekNumber) }}</h2>
	<h3> Van {{ __($week->start) }} t/m {{ $week->end }}</h3>
	
	@if(session()->get('success'))
	    <div class="alert alert-success">
	      {{ session()->get('success') }}  
	    </div>
	@endif

	<a class="btn btn-primary" href="reservations/create">Create reservation</a>

	{{-- show reservations --}}
	<div id="week-reservations" class="pt-4">
		<div class="row"  id="week-view">
			@foreach($week->days as $date)
				<div class="col-md border day-column">
					<div class="row border-bottom p-2 justify-content-center day-column-header">
						
						<h4>{{ ucfirst($date->day) }}</h4> 
						<p>{{ $date->date }}</p>
					</div>
					
					@forelse ($date->reservations as $reservation)

						<div class="pt-2 reservation-wrapper"> 
							<div class="row">
								<div class="col-sm-7">
									<a href="{{ route('reservations.edit',$reservation->id)}} ">{{$reservation->name}}</a>
								</div>
								<div class="col-sm">
									<p>{{$reservation->size}}P</p>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<p>{{ $reservation->startTime }}</p>
								</div>
							</div>
						</div>

					
					@empty
						<p>Geen reserveringen</p>
					@endforelse
				</div>
			@endforeach		
		</div>
	</div>


@endsection