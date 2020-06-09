@section('submenu')
	{{-- create submenu for type --}}

<div class="container">
   <div class="row py-4">
		@if($request)
			<div class="col-2">
				<a class="btn btn-primary" href="{{ route('bowling.change', ['date'=> $date, 'go' => 'prev']) }}">Vorige</a>
			</div>
			<div class="col-8"></div>
			<div class="col-2 d-flex justify-content-end">
				<a class="btn btn-primary" href="{{ route('bowling.change', ['date'=> $date, 'go' => 'next']) }}">Volgende</a>
			</div>
		@endif	
	</div>
</div>


	


@endsection