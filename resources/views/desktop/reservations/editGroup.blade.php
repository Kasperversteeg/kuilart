@extends('layouts.desktop')

@section('content')
	<div class="container pt-2">
	{{-- add reservation --}}
		<div class="row border justify-content-center reservations-container p-2">
			<div class="col-sm-12 p-2">
				<h1 class="display-4">Pas groep aan</h1>
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
			      <form method="post" action="{{ route('groups.update', $reservation->id) }}">
			          @method('PATCH')
			          @csrf
			          {{-- name and size input --}}
			          <div class="row">
			          	<div class="col-md-6">
					        <div class="form-group">    
					            <label for="name">Name</label>
					            <input type="text" class="form-control" name="name" value='{{ old('name') ? old('name') : $reservation->name}}'/>
					        </div>
					    </div>
			          	<div class="col-md-6">
				          <div class="form-group">    
				              <label for="size">Aantal personen</label>
				              <input type="text" class="form-control" name="size" value='{{ old('size') ? old('size') : $reservation->size}}'/>
				          </div>
					    </div>
			          </div>
			          {{-- date and time input --}}
			          <div class="row">
			          	<div class="col-md-6">
					        <div class="form-group">    
					            <label for="date">Datum</label>
					            <input type="text" class="form-control" name="date" value="{{ old('date') ? old('date') : $reservation->date}}" />
					        </div>
					    </div>
			          	<div class="col-md-6">
				          <div class="form-group">    
				              <label for="startTime">Tijd</label>
				              <input type="text" class="form-control" name="startTime" value='{{ old('startTime') ? old('startTime') : $reservation->startTime}}'/>
				          </div>
					    </div>
			          </div>

					
			          {{-- ACTIVITY --}}				
					<hr />
					@foreach($activities as $activity) 
						<h5>Activiteiten</h5>
				          <div class="row activity-row">
				          	<div class="col-md-6">
						        <div class="form-group">    
						            <label for="description">Name</label>
						            <input type="text" class="form-control" name="act-description" value='{{ old('act-description') ? old('act-description') : $activity->description}}'/>
						        </div>
						    </div>
				          	{{-- start- and endTime--}}
				          	<div class="col-md-2">
					          <div class="form-group">    
					              <label for="act-startTime">Start</label>
					              <input type="text" class="form-control" name="act-startTime" value='{{ old('name') ? old('name') : $activity->startTime}}'/>
					          </div>
						    </div>
				          	<div class="col-md-2">
					          <div class="form-group">    
					              <label for="act-endTime">Einde</label>
					              <input type="text" class="form-control" name="act-endTime" value='{{ old('name') ? old('name') : $activity->endTime}}'/>
					          </div>
					         </div>
				          	<div class="col-md-2">
					          <div class="form-group">    
					              <label for="act-size">Aantal personen</label>
					              <input type="text" class="form-control" name="act-size" value='{{ old('name') ? old('name') : $activity->size}}'/>
					          </div>
						    </div>
				         </div>
				     @endforeach
			          

			          <formline v-for="item in fields" :key='item.id' v-bind:id="item.name">

			          </formline>

						<button type="button" v-on:click="addActivity('test')">Add</button>
						<hr />
						
						{{-- description input --}}
			          <div class="form-group">    
			              <label for="notes">Opmerking</label>
			              <input type="text" class="form-control" name="notes" value='{{ old('notes')}}'/>
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
