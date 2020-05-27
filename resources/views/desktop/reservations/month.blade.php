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
			<div class="col d-flex justify-content-center"><h4>Maandag</h4></div>
			<div class="col d-flex justify-content-center"><h4>Dinsdag</h4></div>
			<div class="col d-flex justify-content-center"><h4>Woensdag</h4></div>
			<div class="col d-flex justify-content-center"><h4>Donderdag</h4></div>
			<div class="col d-flex justify-content-center"><h4>Vrijdag</h4></div>
			<div class="col d-flex justify-content-center"><h4>Zaterdag</h4></div>
			<div class="col d-flex justify-content-center"><h4>Zondag</h4></div>
		</div>
		@foreach($month as $week)
			<div class="row "> 
				<div class="col border d-flex align-items-center">
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