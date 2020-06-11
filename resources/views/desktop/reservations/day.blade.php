@extends('layouts.desktop')
@section('content')	
	@include('desktop.components.submenu')

	@php
		$var = 'toggleGrp';
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

		<div class="row pb-4 px-3">
			@if( $isGroup === 'RES')
				<a class="btn btn-white btn-add" href="#" @click="toggleRes" >
			        <x-icon icon="plusje" height='34px' width="34px"/>  Voeg een reservering toe
			    </a>
			@elseif($isGroup === 'GRP')
				<a class="btn btn-white btn-add" href="#" @click="toggleGrp" >
			        <x-icon icon="plusje" height='34px' width="34px"/>  Voeg een reservering toe
			    </a>
			@else
			    <a class="dropdown has-dropdown btn btn-white btn-add" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			        <x-icon icon="plusje" height='34px' width="34px"/>  Voeg een reservering toe
			    </a>

		      	<div class="dropdown-menu" aria-labelledby="navbarDropdown" id='nav-dropdown'>
			        <a class="dropdown-item" href="#" @click='toggleGrp'>Groep</a>                            
			        <a class="dropdown-item" href="#"  @click="toggleRes">Restaurant</a>
			        <a class="dropdown-item" href="{{ route('bowling.index', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">Bowlingbaan</a>
			    </div>
			@endif
		</div>

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