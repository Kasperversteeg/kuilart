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
		<div class="row">
			<div class="col-md-8">
				<h1>{{ $title }}reserveringen</h1>
				<h3 class="pb-4">{{ ucfirst(__($day->day)) . ' ' . $day->formattedDate }}</h3>
			</div>
			@if($isGroup === 'GRP')
				<div class="col-md-4 d-flex justify-content-end align-items-end">
					<a href="{{route('groups.index', ['d' => $day->date , 'bar' => false])}}" class="btn btn-white">Lijst</a>
					<a href="{{route('groups.index', ['d' => $day->date , 'bar' => true])}}" class="btn btn-white">Balk</a>
				</div>
			@endif
		</div>
	@endsection
		
	<div class="container day-container py-4" id="reservations">
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