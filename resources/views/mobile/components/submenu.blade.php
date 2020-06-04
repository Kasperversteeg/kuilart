@section('submenu')
	{{-- create submenu for type --}}
@php
	switch($isGroup){
		case('RES'):
			$route = 'restaurant.index';
			break;
		case('GRP'):
			$route = 'groups.index';
			break;
		default:
			$route = 'all.index';
			break;
	}

	$request = Request::query();
	$select = array_key_first($request);
	
	if(array_key_exists($select, $request)){
		$int = $request[$select];
	}



	if (array_key_exists('y', $request)){
		$year = $request['y'];
	} else {
		$now = \Carbon\Carbon::now();
		$year = $now->year;
	}

@endphp
   <div class="row nav-sub-menu "> 
   		@if ($select != 's')
	   		<div class="col-6">
	   			<a href="{{ route('change', ['group' => $isGroup, 'select' => $select, 'int'=> $int, 'go' => 'prev', 'y' => $year]) }}" class="btn btn-primary">Vorige</a>
	   		</div>
   		@endif
       @if ($select != 's')
	       <div class="col-6 d-flex justify-content-end">
	   			<a href="{{ route('change', ['group' => $isGroup, 'select' => $select, 'int'=> $int, 'go' => 'next', 'y' => $year]) }}" class="btn btn-primary float-left">Volgende</a>
	       </div>
       @endif
    </div>
@endsection