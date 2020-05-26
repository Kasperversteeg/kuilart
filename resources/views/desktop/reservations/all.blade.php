@extends('layouts.desktop')

@section('content')

		@include('layouts.submenu')

	

		@if(session()->get('success'))
		    <div class="alert alert-success">
		      {{ session()->get('success') }}  
		    </div>
		@endif

		<h1 class="pt-4 display-4">{{ $isGroup ? 'Groeps' : 'Restaurant'}} reserveringen</h1>

		<a class='btn btn-primary' href="/reservations/create">Create reservation</a>
		
		@php
			$bool = false;
			$rowClass = 'bg-gray';
		@endphp
		{{-- show reservations --}}
		<div id="reservations-container" class="pt-4">
			@foreach($reservations as $date => $object)
				@php
					if($bool === false){
						$bool = true;
						$rowClass = '';
					} else {
						$bool = false;
						$rowClass = '';
					}
				@endphp

				<div class="row justify-content-center">
					<div class="col-sm-12 p-2 {{ $rowClass }} border mb-4">	 
						<h3>{{ ucfirst($object->dayName) . ' ' .  $object->date }}</h3>
						<hr />
						@foreach($object->reservations as $reservation)
							<div class="row reservation-full pb-2">
								<div class="col-md-9"> 
									<a href="{{ route('reservations.edit',$reservation->id)}} ">{{ $reservation->name }}</a>
								</div>
								<div class="col-md-3">
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
						@endforeach
					</div>
				</div>
			@endforeach
		</div>
	





@endsection
