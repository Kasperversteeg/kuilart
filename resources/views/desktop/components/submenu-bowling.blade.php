@section('submenu')

	<div class="container py-2">		
	{{-- title of current page --}}
		<div class="row justify-content-center">
			<h1 class="py-1">{{ $title }}</h1>
		</div>
		
		{{-- date, previous and next buttons --}}
		<div class="row justify-content-md-center"> 
			<div class="col-1">
				<a href="{{ route('bowling.change', ['date'=> $date, 'go' => 'prev']) }}" class="btn btn-img">
					<x-icon icon="arrow-left" height='34px' width="34px" />
				</a>
			</div> 
		
			<div class="col-2 justify-content-center submenu-showing">
				<h3 class="d-flex justify-content-center">{{ $showing }}</h3> 
				<h5 class="d-flex justify-content-center">{{ $period ? $period : ''}}</h5>
			</div>	
				
			<div class="col-1">
				<a href="{{ route('bowling.change', ['date'=> $date, 'go' => 'next']) }}" class="btn btn-img float-left">
					<x-icon icon="arrow-right" height='34px' width="34px" />
				</a>
			</div>
		</div>
	</div>

@endsection