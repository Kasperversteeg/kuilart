@extends('layouts.desktop')

@php
switch($isGroup){
	case('RES'):
		$route = 'desktop.components.all.res-view';
		$title = 'Restaurant ';
		$modalTitle = "Voeg een restaurant reservering toe";
		break;
	case('GRP'):
		$route = 'desktop.components.all.grp-view';
		$title = 'Groeps';
		$modalTitle = "Voeg een groepsreservering toe";
		break;
	default:
		$route = 'desktop.components.all.all-view';
		$title = 'Alle ';
		$modalTitle = "";
		break;
}
@endphp


@section('content')

@include('desktop.components.submenu', [
	'showing' => '', 
	'period' => '', 
	'isGroup' =>  $isGroup,
	'title' => $title
	])

	<div class="container bg-white" id="reservations-container" >
		@foreach($reservations as $date => $object)
			{{-- Check for all, if so split the reservations --}}
			@if($isGroup === 'ALL')
				<div class="col-sm-12 border-bottom border-left border-right">	
					<div class="row">
						<div class="col-12 border-bottom py-2 d-flex align-items-center">
							<h3 class="all-dayname">{{ ucfirst($object->dayName)}}<span class="all-date"> {{$object->date}}</span></h3>
						</div>
					</div>
					
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
				<div class="col-sm-12 p-4 mb-4">	 
					<div class="row">
						<h3>{{ ucfirst($object->dayName) . ' ' .  $object->date }}</h3>
					</div>
					<hr />
					<div class="container py-0">
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
<add reservation-type="{{ $isGroup }}" title='{{ $modalTitle }}' @open='showModal'></add>
</div>

@endsection
