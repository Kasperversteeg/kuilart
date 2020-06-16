@extends('layouts.desktop')
@section('content')
	@php
		switch($isGroup){
			case('RES'):
				$link = 'restaurants.index';
				$route = 'desktop.components.week.res-view';				
				$modalTitle = "Voeg een restaurant reservering toe";
				$title = 'Restaurant ';
				break;
			case('GRP'):
				$link = 'groups.index';
				$route = 'desktop.components.week.grp-view';
				$modalTitle = "Voeg een groepsreservering toe";
				$title = 'Groeps';
				break;
			default:
				$link = 'all.index';
				$route = 'desktop.components.week.all-view';
				$modalTitle = "";
				$title = 'Alle ';
				break;
		}
	@endphp
	
	@include('desktop.components.submenu', [
		'showing' => 'Week '.__($week->weekNumber), 
		'period' =>  __(date('d-m-Y', strtotime($week->start))) .' / '.__(date('d-m-Y', strtotime($week->end))), 
		'isGroup' =>  $isGroup,
		'title' => $title
		])


	{{-- show reservations --}}
	<div id="reservations-week-view" class="reservations-container d-flex">
		@foreach($week->days as $date)
		<div class="col-lg col-12 weekview-day-column p-1">
			<div class="row weekview-day-column-header week-header mb-2">
				<div class="col-12 justify-content-center d-flex {{ $date->date === $today ? 'is-today' : ''}}">
					<h4><a class="week-link" href="{{ route($link, ['d'=> $date->date]) }}">{{ ucfirst($date->day) }}</a></h4> 
				</div>
				<div class="col-12 justify-content-center d-flex">
					<p>{{ date('d-m-y', strtotime($date->date)) }}</p>
				</div>
			</div>

			@foreach($date->reservations as $reservation)
				@if($reservation->type === 'GRP')
					@component('desktop.components.week.grp-view', ['reservation' => $reservation])
					
					@endcomponent
				@endif
				@if($reservation->type === 'RES')
					@component('desktop.components.week.res-view', ['reservation' => $reservation])
					
					@endcomponent
				@endif
			@endforeach



		</div>
		@endforeach		
	</div>

	<add reservation-type="{{ $isGroup }}" title='{{ $modalTitle }}' @open='showModal'></add>

@endsection