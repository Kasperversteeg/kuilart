@extends('layouts.desktop')

@section('content')

	@include('layouts.submenu')	

	@if(session()->get('success'))
	    <div class="alert alert-success">
	      {{ session()->get('success') }}  
	    </div>
	@endif

	<h1 class="pt-4 display-4">{{ $isGroup }} reserveringen</h1>		
	@php
	switch($isGroup){
		case('RES'):
			$route = 'desktop.components.all.res-view';
			break;
		case('GRP'):
			$route = 'desktop.components.all.grp-view';
			break;
		default:
			$route = 'desktop.components.all.all-view';
			break;
	}
	@endphp

	{{-- show reservations --}}
	<div id="reservations-container" class="pt-4">
		@foreach($reservations as $date => $object)
			@if($isGroup === 'ALL')
			<div class="col-sm-12 p-2 border mb-4">	 
				<h3>{{ ucfirst($object->dayName) . ' ' .  $object->date }}</h3>
				<hr />
				@component($route, [
					'groups' => $object->groups, 
					'res' => $object->res
					])

				@endcomponent
			</div>
			@endif
			@if($isGroup === 'RES' || $isGroup === 'GRP')
			<div class="col-sm-12 p-2 {{ $isGroup === 'RES' ? 'border-res' : 'border-grp' }} mb-4">	 
				<h3>{{ ucfirst($object->dayName) . ' ' .  $object->date }}</h3>
				<hr />
				@foreach($object->reservations as $reservation)
					@component($route, [
						'reservation' => $reservation
						])

					@endcomponent
				@endforeach
			</div>
			@endif
		@endforeach
	</div>
	





@endsection
