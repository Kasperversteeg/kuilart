@extends('layouts.desktop')

@php
switch($isGroup){
	case('RES'):
		$route = 'desktop.components.all.res-view';
		$title = 'Restaurant ';
		break;
	case('GRP'):
		$route = 'desktop.components.all.grp-view';
		$title = 'Groeps';
		break;
	default:
		$route = 'desktop.components.all.all-view';
		$title = 'Alle ';
		break;
}
@endphp


@section('content')

	@include('desktop.components.submenu')	
	@section('title')
		<h1 class="pb-4">{{ $title }}reserveringen</h1>		
	@endsection


	<div class="container bg-white">
		{{-- show reservations --}}
		<div id="reservations-container" class="pt-4">
			@foreach($reservations as $date => $object)
				{{-- Check for all, if so split the reservations --}}
				@if($isGroup === 'ALL')
					<div class="col-sm-12 p-2 border mb-4">	
						<h3>{{ ucfirst($object->dayName) . ' ' .  $object->date }}</h3>
						<hr />
						<div class="container">
							@component($route, [
								'groups' => $object->groups, 
								'res' => $object->res
								])

							@endcomponent
						</div>
					</div>
				@endif
				{{-- if not all, get other component --}}
				@if($isGroup === 'RES' || $isGroup === 'GRP')
					<div class="col-sm-12 p-2 {{ $isGroup === 'RES' ? 'border-res' : 'border-grp' }} mb-4">	 
						<h3>{{ ucfirst($object->dayName) . ' ' .  $object->date }}</h3>
						<hr />
						<div class="container">
							@foreach($object->reservations as $reservation)
								@component($route, [
									'reservation' => $reservation
									])

								@endcomponent
							@endforeach
						</div>
					</div>
				@endif
			@endforeach
		</div>
	</div>

	<edit-res v-show="editResShowing" :id="editId" @close="closeReservation"></edit-res>
	<edit-grp v-show="editGrpShowing" :id="editId" @close="closeGroup"></edit-grp>

@endsection
