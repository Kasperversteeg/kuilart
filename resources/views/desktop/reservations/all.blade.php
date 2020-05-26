@extends('layouts.desktop')

@section('content')

		@include('layouts.submenu')

	

		@if(session()->get('success'))
		    <div class="alert alert-success">
		      {{ session()->get('success') }}  
		    </div>
		@endif

		<h1 class="pt-4">{{ $isGroup === true ? 'Groeps' : 'Restaurant'}} Reserveringen</h1>

		<a class='btn btn-primary' href="/reservations/create">Create reservation</a>
		
		@php
			$bool = false;
			$rowClass = 'bg-info';
		@endphp
		{{-- show reservations --}}
		<div id="reservation" class="pt-4">
			@foreach($reservations as $date => $reservations)
			@php
				if($bool === false){
					$bool = true;
					$rowClass = '';
				} else {
					$bool = false;
					$rowClass = 'bg-info';
				}
			@endphp
			<div class="row justify-content-center">
				<div class="col-sm-12 p-2 {{ $rowClass }}">	 
					<h3>{{ $date }}</h3>
					
					@foreach($reservations as $reservation)
						<div class="row">
							<div class="col-md-8">
							
								<h4>{{ $reservation->name }}</h4>
							</div>
							<div class="col-md-4">
								<p>{{ $reservation->size }}</p>
							</div>
							<div class="col-md-12">
								<p>{{ $reservation->notes }}</p>
							</div>
							
						</div>
					@endforeach
				</div>
									<hr />

			</div>
			@endforeach
		</div>
	





@endsection
