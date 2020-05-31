@extends('layouts.desktop')

@section('content')
	<div class="container pt-2">
	{{-- add reservation --}}
		<div class="row border justify-content-center reservations-container p-2">
			<div class="col-sm-12 p-2">
				<h1 class="display-4">Voeg activiteit toe</h1>
			  	<div>
			  		@if(session()->get('success'))
					    <div class="alert alert-success">
					      {{ session()->get('success') }}  
					    </div>
					@endif
			    	@if ($errors->any())
			      	<div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				              <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				      </div><br />
			    	@endif
			      <form method="post" action="{{ route('storeActivity') }}">
			          @csrf
			          {{-- description --}}
			          <div class="row activity-row">
			          	{{-- start- and endTime--}}
			          	<div class="col-md-3">
				          <div class="form-group">    
				              <label for="startTime">Start</label>
				              <input type="text" class="form-control" name="startTime" value='{{ old('startTime')}}'/>
				          </div>
					    </div>
			          	<div class="col-md-3">
				          <div class="form-group">    
				              <label for="endTime">Einde</label>
				              <input type="text" class="form-control" name="endTime" value='{{ old('endTime')}}'/>
				          </div>
					    </div>
			          	<div class="col-md-6">
					        <div class="form-group">    
					            <label for="description">Name</label>
					            <input type="text" class="form-control" name="description" value='{{ old('description')}}'/>
					        </div>
					    </div>
			          </div>
			          
			          <div class="row justify-content-end">
			          	<div class="col-sm-2">
				          <button type="submit" class="btn btn-primary float-right">Voeg toe</button>
				        </div>
			          </div>
			      </form>
			  </div>
			</div>
		</div>
	</div>

@endsection
