]@extends('layouts.desktop')

@section('content')
	<div class="container pt-2">

	{{-- edit reservation --}}

	<div class="row justify-content-center">
		<div class="col-sm-11 p-2">
		    <h1 class="display-3">Edit reservation</h1>
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
		        <ul>
		      <form method="post" action="{{ route('reservations.update', $reservation->id) }}">
		          @method('PATCH')
		          @csrf
		          <div class="form-group">    
		              <label for="name">Naam</label>
		              <input type="text" class="form-control" name="name" value="{{$reservation->name}}"/>
		          </div>

				<div class="form-group">    
			            <label for="description">Datum</label>
			            <input type="text" class="form-control" name="date" value="{{$reservation->date}}"/>
			    </div>

		          <div class="form-group">    
		              <label for="description">Omschrijving</label>
		              <input type="text" class="form-control" name="description" value="{{$reservation->description}}"/>
		          </div>  

		          <button type="submit" class="btn btn-primary">Edit reservation</button>
		      </form>
		      <form method="post" action="{{ route('reservations.destroy', $reservation->id) }}">
		          @method('DELETE')
		          @csrf
			      <button type="submit" class="btn btn-primary">Delete reservation</button>
		      </form>
		  </div>
		 </div>
		</div>

	</div>

@endsection
