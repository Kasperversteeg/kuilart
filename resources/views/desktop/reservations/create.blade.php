@extends('layouts.desktop')

@section('content')
	<div class="container pt-2">
	{{-- add reservation --}}
		<div class="row border justify-content-center reservations-container p-2">
			<div class="col-sm-12 p-2">
				<h1 class="display-4">Voeg resevering toe</h1>
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
			      <form method="post" action="{{ route('reservations.store', ['prev' => $prevUrl]) }}">
			          @csrf
			          {{-- type input --}}
			          <div class="form-group">    
			              <label for="type">Type</label>
			              <select name="type" id="reservationType">
			              	<option value="GRP" selected="selected">Groep</option>
			              	<option value="RES">Restaurant</option>
			              </select>
			          </div>
			          {{-- name and size input --}}
			          <div class="row">
			          	<div class="col-md-6">
					        <div class="form-group">    
					            <label for="name">Name</label>
					            <input type="text" class="form-control" name="name" value='{{ old('name')}}'/>
					        </div>
					    </div>
			          	<div class="col-md-6">
				          <div class="form-group">    
				              <label for="size">Aantal personen</label>
				              <input type="text" class="form-control" name="size" value='{{ old('size')}}'/>
				          </div>
					    </div>
			          </div>
			          {{-- date and time input --}}
			          <div class="row">
			          	<div class="col-md-6">
					        <div class="form-group">    
					            <label for="date">Datum</label>
					            <input type="text" class="form-control" name="date" value="{{ old('date') ? old('date') : date('d-m-yy', strtotime($date))}}" />
					        </div>
					    </div>
			          	<div class="col-md-6">
				          <div class="form-group">    
				              <label for="startTime">Tijd</label>
				              <input type="text" class="form-control" name="startTime" value='{{ old('startTime')}}'/>
				          </div>
					    </div>
			          </div>
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
