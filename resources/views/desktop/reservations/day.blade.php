@extends('layouts.desktop')
@section('content')	
	@include('desktop.components.submenu')

	@php

		switch($isGroup){
			case('RES'):
				$title = 'Restaurant ';
				$route = 'desktop.components.day.res-list-view';
				break;
			case('GRP'):
				$title = 'Groeps';
				$route = 'desktop.components.day.grp-list-view';
				break;
			default:
				$route = 'desktop.components.day.all-list-view';
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

	<edit-res v-show="editResShowing" :id="editId" @close="closeReservation"></edit-res>
	<edit-grp v-show="editGrpShowing" :id="editId" @close="closeGroup"></edit-grp>
	</div>
@endsection