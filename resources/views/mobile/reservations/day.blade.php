@extends('layouts.mobile')
@section('content')	

	@php
		switch($isGroup){
			case('RES'):
				$modalTitle = 'test';
				$title = 'Restaurant ';
				break;
			case('GRP'):
				$modalTitle = 'test';
				$title = 'Groeps';
				break;
			default:
				$modalTitle = 'test';
				$title = 'Alle ';
				break;
		}
	@endphp

	<h1 class="pt-4">{{ $title }}reserveringen</h1>
	<h3 class="pt-4">{{ ucfirst(__($day->day)) . ' ' . __(date('d-m-y', strtotime($day->date))) }}</h3>
	

		@forelse($day->reservations as $reservation)
			@if($reservation->type === 'GRP')
				@component('mobile.components.day.grp-list-view', ['reservation' => $reservation])
				
				@endcomponent
			@endif
			@if($reservation->type === 'RES')
				@component('mobile.components.day.res-list-view', ['reservation' => $reservation])
				
				@endcomponent
			@endif

		@empty
			<p>Geen reserveringen voor vandaag</p>
		@endforelse

		<add reservation-type="{{ $isGroup }}" title='{{ $modalTitle }}' @open='showModal'></add>

	</div>
@endsection