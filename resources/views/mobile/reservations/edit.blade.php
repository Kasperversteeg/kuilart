@extends('layouts.mobile')

@section('content')
	<div class="container pt-2">

	{{-- edit reservation --}}

	<div class="row justify-content-center border">
		<div class="col-sm-12 p-2">
		    <h1 class="display-4">Pas reservering aan</h1>
		  <div>
		    @if ($errors->any())
		      <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		              <li>{{ __($error) }}</li>
		            @endforeach
		        </ul>
		      </div><br />
		    @endif
		    <form method="post" action="{{ route('reservations.update', $reservation->id) }}">
	          @method('PATCH')
	          @csrf
		          {{-- type input --}}
		          <div class="form-group">    
		              <label for="type">Type</label>
		              <select name="type" id="reservationType">
		              	<option value="GRP" {{ $reservation->type === 'GRP' ? "selected='selected'" : '' }}>Groep</option>
		              	<option value="RES" {{ $reservation->type === 'RES' ? "selected='selected'" : '' }}>Restaurant</option>
		              </select>
		          </div>
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
			              <input type="text" class="form-control" name="startTime" value='{{ old('startTime') ? old('startTime') : $reservation->startTime }}'/>
			          </div>
				    </div>
		          </div>
					{{-- description input --}}
		          <div class="form-group">    
		              <label for="notes">Opmerking</label>
		              <input type="text" class="form-control" name="notes" value='{{ old('notes') ? old('notes') : $reservation->notes }}'/>
		          </div>  
			          <button type="submit" class="btn btn-primary float-right">Pas aan</button>
			       </form>


		          <div class="row">
		          	<div class="col-sm-2">
			          	<form method="post" action="{{ route('reservations.destroy', $reservation->id) }}">
				          @method('DELETE')
				          @csrf
					      <button type="submit" class="btn btn-danger">Delete reservation</button>
				      	</form>
				      </div>
		          	<div class="col-sm-8 col-0"></div>
		          	<div class="col-sm-2">
			        </div>
		        </div>  
		  </div>
		 </div>
		</div>

	</div>

@endsection
