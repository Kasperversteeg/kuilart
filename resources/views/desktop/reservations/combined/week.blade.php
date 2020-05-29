@extends('layouts.desktop')
@section('content')


	@include('layouts.submenu')

	<h1 class="pt-4 display-4">Alle reserveringen</h1>

	<h3 class="pt-4">Week:{{__($week->weekNumber) }} Van {{ __($week->start) }} t/m {{ $week->end }}</h3>
	
	@if(session()->get('success'))
	    <div class="alert alert-success">
	      {{ session()->get('success') }}  
	    </div>
	@endif

	{{-- show reservations --}}
	<div id="reservations-week" class="pt-4 reservations-container">
		<div class="row"  id="reservations-week-view">
			@foreach($week->days as $date)
				<div class="col-md border day-column">
					<div class="row border-bottom p-2 -center day-column-header">
						<div class="col-12 justify-content-center d-flex"><h4><a href="{{ route('all', 'd='.$date->date)}}">{{ ucfirst($date->day) }}</a></h4> </div>
						<div class="col-12 justify-content-center d-flex"><p>{{ date('d-m-y', strtotime($date->date)) }}</p>
					</div>
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
									<p>{{ date('H:i', strtotime($reservation->startTime)) }}</p>
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