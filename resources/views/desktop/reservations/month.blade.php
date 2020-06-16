@extends('layouts.desktop')
@section('content')
	@php
	switch($isGroup){
		case('GRP'):
			$route = 'desktop.components.month.grp-view';
			$modalTitle = "Voeg een groepsreservering toe";
			$link = 'groups.index';
			$title = 'Groeps';
			break;
		default:
			$route = 'desktop.components.month.all-view';
			$modalTitle = "";
			$link = 'all.index';
			$title = 'Alle ';
			break;
	}
	@endphp

	@include('desktop.components.submenu', [
		'showing' => ucfirst(__($monthName)), 
		'period' => $year, 
		'isGroup' =>  $isGroup,
		'title' => $title
		])

	{{-- show reservations --}}
	<div id="reservations-month-view" class="reservations-container">
		<div class="row month-view-headers week-header">
			<div class="col week-number-cell"></div>
			<div class="col day-cell"><h4>Maandag</h4></div>
			<div class="col day-cell"><h4>Dinsdag</h4></div>
			<div class="col day-cell"><h4>Woensdag</h4></div>
			<div class="col day-cell"><h4>Donderdag</h4></div>
			<div class="col day-cell"><h4>Vrijdag</h4></div>
			<div class="col day-cell"><h4>Zaterdag</h4></div>
			<div class="col day-cell"><h4>Zondag</h4></div>
		</div>
		
		@foreach($month as $week)
			<div class="row month-view-row"> 
				<div class="col week-number-cell d-flex align-items-center justify-content-center p-0">
					<a href="{{ route($link, ['w'=>$week->weekNumber, 'y' => $year])}}">Week {{ $week->weekNumber }}</a>
				</div>
				@foreach($week->days as $day)
					<div class="col border-bottom border-left px-1">
						<div class="container px-0">
							<div class="row justify-content-end month-daynumber px-3 py-1">
								<a class="month-view-date-link {{  $day->date === $today ? 'is-today' : ''  }}" href="{{ route($link, 'd='.$day->date)}}" >{{date('d', strtotime($day->date))}}</a>
							</div>
							@foreach( $day->reservations as $reservation)
								@component('desktop.components.month.grp-view', ['reservation' => $reservation])					
								@endcomponent
							@endforeach
						</div>
					</div>
				@endforeach
			</div>
		@endforeach
		
		</div>
	

	<add reservation-type="{{ $isGroup }}" title='{{ $modalTitle }}' @open='showModal'></add>

@endsection