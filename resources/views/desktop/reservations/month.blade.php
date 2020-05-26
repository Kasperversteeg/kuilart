@extends('layouts.desktop')

@section('content')

	@include('layouts.submenu')

	{{-- <h1>Welcome {{ Auth::user()->name }} </h1> --}}

	@if(session()->get('success'))
	    <div class="alert alert-success">
	      {{ session()->get('success') }}  
	    </div>
	@endif

	<h1 class="pt-4 display-4">{{ $isGroup === true ? 'Groepen' : 'Restaurant'}}</h2>
	<h1 class="pt-4">{{ ucfirst($monthName) }}</h1>
	

	{{-- show reservations --}}
	<div id="reservations-month" class="pt-4 reservations">
		<div class="row">
			<div class="col"></div>
			<div class="col">Maandag</div>
			<div class="col">Dinsdag</div>
			<div class="col">Woensdag</div>
			<div class="col">Donderdag</div>
			<div class="col">Vrijdag</div>
			<div class="col">Zaterdag</div>
			<div class="col">Zondag</div>
		</div>
		@foreach($month as $week)
			<div class="row "> 
				<div class="col border">
					<p>Week {{ $week->weekNumber }}</p>
				</div>
				@foreach( $week->days as $day)
					<div class="col border">
						<p class="text-right">{{date('D d', strtotime($day->date))}}</p>
						@forelse( $day->reservations as $reservation)
							<a href="{{ route('reservations.edit',$reservation->id)}} ">{{ $reservation->name }}</a>
						@empty
						<p>-</p>
						@endforelse
					</div>
				@endforeach
			</div>		

		@endforeach
	</div>
	





@endsection