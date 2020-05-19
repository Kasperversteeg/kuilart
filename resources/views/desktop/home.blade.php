@extends('layouts.desktop')

@section('content')
	<div class="container pt-2">

		<h1>Welcome {{ Auth::user()->name . ' ' .  $device}} </h1>
		<h2>Het is vandaag {{ ucfirst(__($now))}}</h2>

  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div>
  @endif
	

	{{-- make reservation --}}

		<div class="row">
		 <div class="col-sm-8">
		    <h1 class="display-3">Add a contact</h1>
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
		              <label for="description">Name</label>
		              <input type="text" class="form-control" name="description"/>
		          </div>             
		          <button type="submit" class="btn btn-primary">Add reservation</button>
		      </form>
		  </div>
		 </div>
		</div>

		{{-- show reservations --}}
		<div id="reservation" class="pt-4">
			@foreach($reservations as $reservation)
				<div class="row border"> 
					<div class="col-sm-8">		
						<p>{{$reservation->id}} {{$reservation->name}} {{$reservation->description}} <a href="{{ route('reservations.edit',$reservation->id)}}" class="btn btn-primary">Edit</a></p>
					</div>
				</div>
			@endforeach
		</div>
	</div>

@endsection
