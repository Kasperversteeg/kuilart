@extends('layouts.desktop')
@section('content')

	<h2 class="pt-4">Reserveringen voor {{__($reservationsForDay->day) . ' ' . __($reservationsForDay->date) }}</h2>
	<a href="reservations/create">Create reservation</a>

	{{-- show reservations --}}
	<div id="reservation" class="pt-4">
		@forelse($reservationsForDay->reservations as $reservation)
			<div class="row border"> 
				<div class="col-sm-8">		
					<a href="{{ route('reservations.edit',$reservation->id)}}">{{$reservation->name}}</a>
					<p>{{$reservation->date}}</p>
					<p>{{$reservation->description}}</p>
				</div>
			</div>
		@empty
			<p>Geen reserveringen voor vandaag</p>
		@endforelse
	</div>
@endsection