@extends('layouts.desktop')

@section('content')

		@include('layouts.submenu')

		@if(session()->get('success'))
		    <div class="alert alert-success">
		      {{ session()->get('success') }}  
		    </div>
		@endif
	
		<h1 class="pt-4 display-4">Alle reserveringen</h1>

		@php
			$bool = false;
			$rowClass = 'bg-gray';
		@endphp
	
		{{-- show reservations --}}
		<div id="reservations-container" class="pt-4">
			@foreach($reservations as $date => $object)
				@php
					if($bool === false){
						$bool = true;
						$rowClass = '';
					} else {
						$bool = false;
						$rowClass = 'bg-gray';
					}
				@endphp

				<div class="day-wrapper row border p-2 mb-4 {{ $rowClass }}">
					<div class="col-12 day-header">	 
						<h3>{{ ucfirst($object->dayName) . ' ' .  $object->date }}</h3>
					</div>

					{{-- Foreach group reservation in the day object --}}
					<div class="col-12 group-wrapper mb-4">
						<div class="col-12">
							<p class="font-weight-bold mb-0 border-bottom">Groepen</p>
						</div>
						@foreach($object->groups as $group)
						<div class="row">
							<div class="col-md-12 reservation-group border">
								<a href="{{ route('reservations.edit',$group->id)}} ">{{ $group->name }}</a>
							</div>
							<div class="col-md-12">
								
							</div>
						</div>
						@endforeach
					</div>

					{{-- Foreach restaurant reservation in the day object --}}
					<div class="col-12 res-wrapper mb-4">
						<div class="col-12">
							<p class="font-weight-bold mb-0 border-bottom">Restaurant</p>
						</div>	
						@foreach($object->res as $res)
							<div class="row pl-3">
								<div class="col-md-10"> 
									<a href="{{ route('reservations.edit',$res->id)}} ">{{ $res->name }}</a>
								</div>
								<div class="col-md-1"> 
									<p>{{ date('H:i', strtotime($res->startTime)) }}</p>
								</div>
								<div class="col-md-1"> 
									<p>{{ $res->size }} P</p>
								</div>
							</div>
						@endforeach						
					</div>	
				</div>
			@endforeach
		</div>

@endsection