@extends('layouts.desktop')

@section('content')
	

		<h1>Welcome {{ Auth::user()->name }} </h1>
		<p>Het is vandaag {{ ucfirst(__($now))}}</p>

		@if(session()->get('success'))
		    <div class="alert alert-success">
		      {{ session()->get('success') }}  
		    </div>
		@endif

		<h2 class="pt-4">Alle Reserveringen</h2>

		<a class='btn btn-primary' href="reservations/create">Create reservation</a>

		{{-- show reservations --}}
		<div id="reservation" class="pt-4">
			@forelse($reservations as $reservation)
				<div class="row border"> 
				<div class="col-sm-8">		
					<a href="{{ route('reservations.edit',$reservation->id)}}">{{$reservation->name}}</a>
					<p>{{$reservation->date}}</p>
					<p>{{$reservation->description}}</p>
				</div>
			</div>
			@empty
				<p>Geen reserveringen om weer te geven</p>
			@endforelse
		</div>
	





@endsection
