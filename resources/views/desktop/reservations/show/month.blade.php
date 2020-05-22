@extends('layouts.desktop')

@section('content')
	

		{{-- <h1>Welcome {{ Auth::user()->name }} </h1> --}}

		@if(session()->get('success'))
		    <div class="alert alert-success">
		      {{ session()->get('success') }}  
		    </div>
		@endif

		<h1 class="pt-4">{{ ucfirst($monthName) }}</h2>

		<a class='btn btn-primary' href="reservations/create">Create reservation</a>

		{{-- show reservations --}}
		<div id="reservations-month" class="pt-4 reservations">
			@foreach($month as $week)
				<div class="row border"> 
					<div class="col border">
						<p>Week {{ $week->weekNumber }}</p>
					</div>
					@foreach( $week->days as $day)
						<div class="col border">
							<p>{{ $day->date}}</p>
							@forelse( $day->reservations as $reservation)
								<p>{{ $reservation->name }}</p>
							@empty
							<p>-</p>
							@endforelse
						</div>
					@endforeach
				</div>		
			@endforeach
		</div>
	





@endsection