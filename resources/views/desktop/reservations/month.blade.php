@extends('layouts.desktop')

@section('content')
	@include('desktop.components.submenu')

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
	$bool = false;
	@endphp
	@section('title')
		<h1 class="pb-4">{{ $title }}reserveringen <small>{{ ucfirst($monthName) . ' ' . $year }}</small></h2>
	@endsection

	{{-- show reservations --}}
	<div id="reservations-month" class="reservations-container">
		<div class="row  pb-3">
			<div class="col-1"></div>
			<div class="col d-flex justify-content-center"><h4>Maandag</h4></div>
			<div class="col d-flex justify-content-center"><h4>Dinsdag</h4></div>
			<div class="col d-flex justify-content-center"><h4>Woensdag</h4></div>
			<div class="col d-flex justify-content-center"><h4>Donderdag</h4></div>
			<div class="col d-flex justify-content-center"><h4>Vrijdag</h4></div>
			<div class="col d-flex justify-content-center"><h4>Zaterdag</h4></div>
			<div class="col d-flex justify-content-center"><h4>Zondag</h4></div>
		</div>
		@foreach($month as $week)
			<div class="row month-view-row"> 
				<div class="col-1 d-flex align-items-center">
					<a href="{{ route($link, ['w'=>$week->weekNumber, 'y' => $year])}}">Week {{ $week->weekNumber }}</a>
				</div>
				@foreach($week->days as $day)
					<div class="col border-bottom border-left px-1">
						<div class="container">
							<div class="row justify-content-end month-daynumber">
								<a href="{{ route($link, 'd='.$day->date)}}" class="{{ $day->date === $today ? 'is-today' : ''  }}">{{date('d', strtotime($day->date))}}</a>
							</div>

							@forelse( $day->reservations as $reservation)
								@php		
									if($bool){
										$bool = false;
									} else {
										$bool = true;
									}
								@endphp
								<div class="row {{ $bool ? '' : 'bg-gray' }}">
									@component('desktop.components.month.grp-view', ['reservation' => $reservation])
									
									@endcomponent
								</div>

							@empty
								@php $bool = false @endphp
							@endforelse
						</div>
					</div>
				@endforeach
			</div>		

		@endforeach
	</div>

	<add reservation-type="{{ $isGroup }}" title='{{ $modalTitle }}' @open='showModal'></add>

@endsection