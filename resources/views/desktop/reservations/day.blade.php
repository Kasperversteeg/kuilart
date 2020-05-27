@extends('layouts.desktop')
@section('content')
	
	@include('layouts.submenu')


	<h1 class="pt-4 display-4">{{ $isGroup ? 'Groepen' : 'Restaurant' }}</h1>
	<h3 class="pt-4">{{ ucfirst(__($reservationsForDay->day)) . ' ' . __(date('d-m-y', strtotime($reservationsForDay->date))) }}</h3>
	
	@if(session()->get('success'))
	    <div class="alert alert-success">
	      {{ session()->get('success') }}  
	    </div>
	@endif

	{{-- show reservations --}}
	<div id="reservation" class="pt-4">
		@forelse($reservationsForDay->reservations as $reservation)
			<div class="row reservation-full mb-2 p-2 border">
				@if(!$isGroup)
					<div class="col-md-2"><p>{{ date('H:i', strtotime($reservation->startTime)) }}</p></div>
				@endif
				<div class="pt-2 col-md-7"> 
					<h4><a href="{{ route('reservations.edit',$reservation->id)}} ">{{ $reservation->name }}</a></h4>
				</div>
				<div class="pt-2 col-md-3">
					<div class="row">
						<div class="col-sm-8 d-flex justify-content-end">
							<p>Aantal personen:</p>
						</div>
						<div class="col-sm-4">
							<p>{{ $reservation->size }}</p>
						</div>
					</div>
					
				</div>
				
				@if($isGroup)
					<div class="col-md-12">
						<p>Activiteit 1</p>
					</div>
				@endif

				
				<hr />
			</div>
		@empty
			<p>Geen reserveringen voor vandaag</p>
		@endforelse
	</div>
@endsection