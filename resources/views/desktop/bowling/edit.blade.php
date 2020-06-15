@extends('layouts.desktop')

@php
	$request = Request::query();
	$select = array_key_first($request);
	
	if(array_key_exists($select, $request)){
		$date = $request[$select];
	}

@endphp

@include('desktop.components.submenu-bowling')
@section('title')
	<h1 class="pb-4">Bowling <small>{{date('d-m-Y', strtotime($current->date)) }}</small></h1>
@endsection

@section('content')
	<div class="container bowling-view-container py-4" id="bowling-container">
		<div class="row border-bottom">
			<div class="col"></div>
			<div class="col"><p>Baan 1</p></div>
			<div class="col"><p>Baan 2</p></div>
			<div class="col"><p>Baan 3</p></div>
			<div class="col"><p>Baan 4</p></div>
		</div>
		@foreach($rows as $row)
			<div class="row border-bottom bowling-row">
				<div class="col">
					<p>{{ $row->startTime . ' t/m '. $row->endTime}} </p>
				</div>
				@foreach($row->lanes as $lane => $reservation)
					@if($reservation == false)
						<div class="col empty-slot" id="{{ $lane.'-'.$row->startTime}}"></div>
					@else
						<div class="col full-slot">
							<a href="{{ route('bowling.edit',$reservation->id) }}" > {{ $reservation->name }}</a>
						</div>
					@endif
				@endforeach
			
			</div>
		@endforeach
	</div>

	<div class="container">
	{{-- add reservation --}}
		<div class="row border justify-content-center reservations-container p-2">
			<div class="col-sm-12 p-2">
				<h3>Voeg bowlingbaan toe</h3>
			  	<div>
			    	@if ($errors->any())
			      	<div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				              <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				      </div><br />
			    	@endif
			      <form method="post" action="{{ route('bowling.update', $current->id) }}">
			      	@method('PATCH')
			          @csrf			          
			          {{-- name and size input --}}
			          <div class="row">
			          	<div class="col-md-6">
					        <div class="form-group">    
					            <label for="name">Naam</label>
					            <input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $current->name }}"/>
					        </div>
					    </div>
			          	<div class="col-md-6">
				          <div class="form-group">    
				              <label for="lane">Baan nummer</label>
				              <select class="form-control" name="lane" id="lane">
				              	<option {{ $current->lane === 1 ? 'selected' : '' }}>1</option>
				              	<option {{ $current->lane === 2  ? 'selected' : '' }}>2</option>
				              	<option {{ $current->lane === 3  ? 'selected' : '' }}>3</option>
				              	<option {{ $current->lane === 4  ? 'selected' : '' }}>4</option>
				              </select>
				          </div>
					    </div>
			          </div>
			          {{-- date and time input --}}
			          <div class="row">
			          	<div class="col-md-6">
					        <div class="form-group">    
					            <label for="date">Datum</label>
					            <input type="text" class="form-control" name="date" value="{{ old('date') ? old('date') : date('d-m-Y', strtotime($current->date))}}"  />
					        </div>
					    </div>
			          	<div class="col-md-3">
					        <div class="form-group">    
				              <label for="startTime">Start tijd</label>
				              <select class="form-control" name="startTime" id="startTime">
				              	<option {{ old('startTime') === '17:00' || $current->startTime === '17:00:00' ? 'selected' : '' }}>17:00</option>
				              	<option {{ old('startTime') === '18:00' || $current->startTime === '18:00:00' ? 'selected' : '' }}>18:00</option>
				              	<option {{ old('startTime') === '19:00' || $current->startTime === '19:00:00' ? 'selected' : '' }}>19:00</option>
				              	<option {{ old('startTime') === '20:00' || $current->startTime === '20:00:00' ? 'selected' : '' }}>20:00</option>
				              	<option {{ old('startTime') === '21:00' || $current->startTime === '21:00:00' ? 'selected' : '' }}>21:00</option>
				              </select>
					        </div>
					    </div>
			          	<div class="col-md-3">
				          <div class="form-group">    
				              <label for="endTime">Eind tijd</label>
				              <select class="form-control" name="endTime" id="endTime">
				              	<option {{ old('endTime') === '18:00' || $current->endTime === '18:00:00' ? 'selected' : '' }}>18:00</option>
				              	<option {{ old('endTime') === '19:00' || $current->endTime === '19:00:00' ? 'selected' : '' }}>19:00</option>
				              	<option {{ old('endTime') === '20:00' || $current->endTime === '20:00:00' ? 'selected' : '' }}>20:00</option>
				              	<option {{ old('endTime') === '21:00' || $current->endTime === '21:00:00' ? 'selected' : '' }}>21:00</option>
				              	<option {{ old('endTime') === '22:00' || $current->endTime === '22:00:00' ? 'selected' : '' }}>22:00</option>
				              </select>
				          </div>
					    </div>
			          </div>				
					          
			          <div class="row justify-content-end">
			          	<div class="col-sm-2">
				          <button type="submit" class="btn btn-primary float-right">Pas aan</button>
				        </div>
			          </div>
			      </form>

		        </div> 
			  </div>
			</div>
			<div class="row">
	          	<div class="col-sm-2">
		          	<form method="post" action="{{ route('bowling.destroy', $current->id) }}">
			          @method('DELETE')
			          @csrf
				      <button type="submit" class="btn btn-danger delete-bowling">Verwijder</button>
			      	</form>
			    </div>
		    </div>			
		</div> 
	</div>
	
@endsection