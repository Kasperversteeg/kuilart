@extends('layouts.desktop')
@section('content')
	
	@include('layouts.submenu')


	<h2 class="pt-4">Reserveringen voor {{ ucfirst(__($reservationsForDay->day)) . ' ' . __($reservationsForDay->date) }}</h2>
	<a class="btn btn-primary" href="/reservations/create">Create reservation</a>
	
	@if(session()->get('success'))
	    <div class="alert alert-success">
	      {{ session()->get('success') }}  
	    </div>
	@endif

	{{-- show reservations --}}
	<div id="reservation" class="pt-4">
		@forelse($reservationsForDay->reservations as $reservation)
		<div class="row border justify-content-center">
			<div class="col-sm-11 p-2">	
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