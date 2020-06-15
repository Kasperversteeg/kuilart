@extends('layouts.desktop')
@section('content')	
	@include('desktop.components.submenu')

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
	
	@section('title')
	<h1>{{ $title }}reserveringen</h1>
	<h3 class="pb-4">{{ ucfirst(__($day->day)) . ' ' . __(date('d-m-y', strtotime($day->date))) }}</h3>
	@endsection
		
	<div class="container day-container py-4" id="reservations">

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
	</div>

	<add reservation-type="{{ $isGroup }}" title='{{ $modalTitle }}' @open='showModal'></add>

@endsection