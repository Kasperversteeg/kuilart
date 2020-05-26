@section('submenu')
	{{-- create submenu for type --}}

	@php
		$route = '';
		if($isGroup){
			$route = 'showGroups';
		} else {
			$route = 'showRestaurant';
		}

		foreach (Request::query() as $key => $value) {
			$select = $key;
			$int = $value;
		}

	@endphp
	   <div class="row nav-sub-menu justify-content-center"> 
	   		@if ($select != 's')
	   		<div class="col-1">
	   			<a href="{{ route('change', ['group' => $isGroup, 'select' => $select, 'int'=> $int, 'go' => 'prev']) }}" class="btn btn-primary">Vorige</a>
	   		</div>
	   		@endif
	   		<div class="col-10 d-flex justify-content-center">
		       <ul style="list-style: none;">
		           <li style="display: inline-block;"><a class="btn btn-primary" href="{{ route($route, 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">Dag</a></li>
		           <li style="display: inline-block;"><a class="btn btn-primary" href="{{ route($route, 'w='.\Carbon\Carbon::now()->weekOfYear) }}">Week</a></li>
					@if($isGroup)
			           <li style="display: inline-block;" ><a class="btn btn-primary" href="{{ route('showGroups', 'm='.\Carbon\Carbon::now()->month) }}">Maand</a></li>
					@endif
		           <li style="display: inline-block;"><a class="btn btn-primary" href="{{ route($route, 's='.'all') }}">Alle</a></li>
		       </ul>
	       </div>
	       @if ($select != 's')

	       <div class="col-1">
	   			<a href="{{ route('change', ['group' => $isGroup, 'select' => $select, 'int'=> $int, 'go' => 'next']) }}" class="btn btn-primary float-left">Volgende</a>
	       </div>
	       @endif

	    </div>





@endsection