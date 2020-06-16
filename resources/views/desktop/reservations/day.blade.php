@extends('layouts.desktop')
@section('content')	
	@php
		$var = 'toggleGrp';
		switch($isGroup){
			case('RES'):
				$title = 'Restaurant ';
				$route = 'desktop.components.day.res-list-view';
				$modalTitle = "Voeg een restaurant reservering toe";
				break;
			case('GRP'):
				$title = 'Groeps';
				$route = 'desktop.components.day.grp-list-view';
				$modalTitle = "Voeg een groepsreservering toe";
				break;
			default:
				$route = 'desktop.components.day.all-list-view';
				$modalTitle = 'Alle';
				$title = 'Alle ';
				break;
		}
	@endphp

	@include('desktop.components.submenu', [
		'showing' => ucfirst(__($day->day)), 
		'period' => $day->formattedDate, 
		'isGroup' => $isGroup, 
		'title' => $title
		])

		<div class="container" id="reservations-day-view">
		@if($bar)
			@component('desktop.components.day.grp-bar-view', ['reservations' => $day->reservations, 'times' => $times])
			@endcomponent
		@else
			@forelse($day->reservations as $reservation)
				@if($reservation->type === 'GRP')
					@component('desktop.components.day.grp-list-view', ['reservation' => $reservation])
					
					@endcomponent
				@endif
				@if($reservation->type === 'RES')
					@component('desktop.components.day.res-list-view', ['reservation' => $reservation])
					
					@endcomponent
				@endif
			@empty
				<p>Geen reserveringen voor vandaag</p>
			@endforelse
		@endif
		
	</div>

	<add reservation-type="{{ $isGroup }}" title='{{ $modalTitle }}' @open='showModal'></add>
@endsection