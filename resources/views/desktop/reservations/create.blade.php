@extends('layouts.desktop')

@section('content')
	<div class="container pt-2">
	{{-- add reservation --}}
		<div class="row border">
			<div class="col-sm-8 p-2">
				<h1>Add a reservation</h1>
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
			      <form method="post" action="{{ route('reservations.store') }}">
			          @csrf
			          <div class="form-group">    
			              <label for="name">Name</label>
			              <input type="text" class="form-control" name="name"/>
			          </div>

			          <div class="form-group">    
			              <label for="date">Datum</label>
			              <input type="text" class="form-control" name="date" value="{{$date}}" />
			          </div>

			          <div class="form-group">    
			              <label for="description">Omschrijving</label>
			              <input type="text" class="form-control" name="description"/>
			          </div>             
			          <button type="submit" class="btn btn-primary">Add reservation</button>
			      </form>
			  </div>
			</div>
		</div>
	</div>




@endsection
