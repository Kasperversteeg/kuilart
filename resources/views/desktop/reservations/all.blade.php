@extends('layouts.desktop')

@section('content')

	@include('layouts.submenu')	

	@if(session()->get('success'))
	    <div class="alert alert-success">
	      {{ session()->get('success') }}  
	    </div>
	@endif

	<h1 class="pt-4 display-4">{{ $isGroup }} reserveringen</h1>		
	@php
		$bool = false;
		$rowClass = 'bg-gray';

	switch($isGroup){
		case('RES'):
			$route = 'desktop.components.all.res-list-view';
			break;
		case('GRP'):
			$route = 'desktop.components.all.grp-list-view';
			break;
		default:
			$route = 'desktop.components.all.all-list-view';
			break;
	}

	@endphp
	{{-- show reservations --}}
	<div id="reservations-container" class="pt-4">
		@foreach($reservations as $date => $object)
			@if($isGroup === 'ALL')
			<div class="col-sm-12 p-2 border mb-4">	 
				<h3>{{ ucfirst($object->dayName) . ' ' .  $object->date }}</h3>
				<hr />
				@component($route, [
					'groups' => $object->groups, 
					'res' => $object->res
					])

				@endcomponent
			</div>
			@endif
		@endforeach
	</div>
	





@endsection
