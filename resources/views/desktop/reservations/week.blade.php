@extends('layouts.desktop')
@section('content')
	@include('desktop.components.submenu')

	@php
		switch($isGroup){
			case('RES'):
				$link = 'restaurants.index';
				$route = 'desktop.components.week.res-view';
				$title = 'Restaurant ';
				break;
			case('GRP'):
				$link = 'groups.index';
				$route = 'desktop.components.week.grp-view';
				$title = 'Groeps';
				break;
			default:
				$link = 'all.index';
				$route = 'desktop.components.week.all-view';
				$title = 'Alle ';
				break;
		}
	@endphp

	<div class="row mb-0">
		<h1 class="pt-4 display-4">{{ $title }}reserveringen <small>Week:{{__($week->weekNumber) }}</small></h1>
	</div>
	<div class="row">
		<h4>{{ __($week->start) }} t/m {{ $week->end }}</h4>
	</div>
	
	@if(session()->get('success'))
	    <div class="alert alert-success">
	      {{ session()->get('success') }}  
	    </div>
	@endif

	@if ($errors->any())
      	<div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	              <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	      </div><br />
    @endif

	{{-- show reservations --}}
	<div id="reservations-week-view" class="pt-4 reservations-container row">
		@foreach($week->days as $date)
		<div class="col-md border weekview-day-column p-1">
			<div class="row border-bottom p-2 weekview-day-column-header mb-4">
				<div class="col-12 justify-content-center d-flex">
					<h4><a href="{{ route($link, ['d'=> $date->date]) }}">{{ ucfirst($date->day) }}</a></h4> 
				</div>
				<div class="col-12 justify-content-center d-flex">
					<p>{{ date('d-m-y', strtotime($date->date)) }}</p>
				</div>
			</div>

			@forelse($date->reservations as $reservation)
				@if($reservation->type === 'GRP')
					@component('desktop.components.week.grp-view', ['reservation' => $reservation])
					
					@endcomponent
				@endif

				@if($reservation->type === 'RES')
					@component('desktop.components.week.res-view', ['reservation' => $reservation])
					
					@endcomponent
				@endif

				@empty
					<p>Nieks</p>
			@endforelse



		</div>
		@endforeach		
	</div>


@endsection