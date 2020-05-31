@extends('layouts.desktop')
@section('content')
	
	@include('layouts.submenu')


	<h1 class="pt-4 display-4">{{ $isGroup }}</h1>
	<h3 class="pt-4">{{ ucfirst(__($day->day)) . ' ' . __(date('d-m-y', strtotime($day->date))) }}</h3>
	
		
	@if(session()->get('success'))
	    <div class="alert alert-success">
	      {{ session()->get('success') }}  
	    </div>
	@endif

	@php
		switch($isGroup){
			case('RES'):
				$route = 'desktop.components.day.res-list-view';
				var_dump('RES');
				break;
			case('GRP'):
				$route = 'desktop.components.day.grp-list-view';
				var_dump('GRP');
				break;
			default:
				$route = 'desktop.components.day.all-list-view';
				var_dump('ALL');
				break;
		}
	@endphp
	
		@forelse($day->reservations as $reservation)
			@component($route, ['reservation' => $reservation])

			@endcomponent

		@empty
			<p>Geen reserveringen voor vandaag</p>
		@endforelse

	
	</div>
@endsection