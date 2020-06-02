@extends('layouts.desktop')

@section('content')
	<div class="container pt-2">
	{{-- add reservation --}}
		<div class="row border justify-content-center reservations-container p-2">
			<div class="col-sm-12 p-2">
				<h1 class="display-4">Voeg bowlingbaan toe</h1>
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
			      <form method="post" action="{{ route('bowling.store') }}">
			          @csrf			          
			          {{-- name and size input --}}
			          <div class="row">
			          	<div class="col-md-6">
					        <div class="form-group">    
					            <label for="name">Naam</label>
					            <input type="text" class="form-control" name="name" value="{{ old('name') }}"/>
					        </div>
					    </div>
			          	<div class="col-md-6">
				          <div class="form-group">    
				              <label for="lane">Baan nummer</label>
				              <select class="form-control" name="lane">
				              	<option {{ old('lane') ? '' : 'selected' }} disabled>Baan nummer</option>
				              	<option {{ old('lane') === '1' ? 'selected' : '' }}>1</option>
				              	<option {{ old('lane') === '2' ? 'selected' : '' }}>2</option>
				              	<option {{ old('lane') === '3' ? 'selected' : '' }}>3</option>
				              	<option {{ old('lane') === '4' ? 'selected' : '' }}>4</option>
				              </select>
				          </div>
					    </div>
			          </div>
			          {{-- date and time input --}}
			          <div class="row">
			          	<div class="col-md-6">
					        <div class="form-group">    
					            <label for="date">Datum</label>
					            <input type="text" class="form-control" name="date" value="{{ old('date') ? old('date') : $date}}"  />
					        </div>
					    </div>
			          	<div class="col-md-3">
					        <div class="form-group">    
				              <label for="startTime">Start tijd</label>
				              <select class="form-control" name="startTime">
				              	<option {{ old('startTime') ? '' : 'selected' }} disabled>Start-tijd</option>
				              	<option {{ old('startTime') === '17:00' ? 'selected' : '' }}>17:00</option>
				              	<option {{ old('startTime') === '18:00' ? 'selected' : '' }}>18:00</option>
				              	<option {{ old('startTime') === '19:00' ? 'selected' : '' }}>19:00</option>
				              	<option {{ old('startTime') === '20:00' ? 'selected' : '' }}>20:00</option>
				              	<option {{ old('startTime') === '21:00' ? 'selected' : '' }}>21:00</option>
				              </select>
					        </div>
					    </div>
			          	<div class="col-md-3">
				          <div class="form-group">    
				              <label for="endTime">Start tijd</label>
				              <select class="form-control" name="endTime">
				              	<option {{ old('endTime') ? '' : 'selected' }} disabled>Start-tijd</option>
				              	<option {{ old('endTime') === '18:00' ? 'selected' : '' }}>18:00</option>
				              	<option {{ old('endTime') === '19:00' ? 'selected' : '' }}>19:00</option>
				              	<option {{ old('endTime') === '20:00' ? 'selected' : '' }}>20:00</option>
				              	<option {{ old('endTime') === '21:00' ? 'selected' : '' }}>21:00</option>
				              	<option {{ old('endTime') === '22:00' ? 'selected' : '' }}>22:00</option>
				              </select>
				          </div>
					    </div>
			          </div>				
						
					          
			          <div class="row justify-content-end">
			          	<div class="col-sm-2">
				          <button type="submit" class="btn btn-primary float-right">Add reservation</button>
				        </div>
			          </div>
			      </form>
			  </div>
			</div>
		</div>
	</div>

@endsection
