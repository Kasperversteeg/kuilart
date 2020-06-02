@extends('layouts.desktop')
@section('content')	
	@include('layouts.submenu')

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

	<h1 class="pt-4 display-4">{{ $title }}reserveringen</h1>
	<h3 class="pt-4">{{ ucfirst(__($day->day)) . ' ' . __(date('d-m-y', strtotime($day->date))) }}</h3>
	
		
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
@endsection