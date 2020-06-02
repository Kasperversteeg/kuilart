@section('submenu')
	{{-- create submenu for type --}}
@php
	$now = \Carbon\Carbon::now();

	switch($isGroup){
		case('RES'):
			$route = 'showRestaurant';
			break;
		case('GRP'):
			$route = 'showGroups';
			break;
		default:
			$route = 'showAll';
			break;
	}

	$request = Request::query();

	$select = array_key_first($request);
	
	if(array_key_exists($select, $request)){
		$int = $request[$select];
	}

	$year = $now->year;

	if (array_key_exists('y', $request)){
		$year = $request['y'];
	}

	// set ulrs for submenu
	$dayUrl = route($route, 'd='.$now->isoFormat('Y-MM-DD'));
	$weekUrl = route($route, ['w' => $now->weekOfYear,'y'=>$now->year]);
	$monthUrl = route($route, ['m'=>$now->month,'y'=>$now->year]);
	$allUrl = route($route, 's='.'all');

@endphp
   <div class="row nav-sub-menu justify-content-center"> 
   		@if ($select != 's')
   		<div class="col-1">
   			<a href="{{ route('change', ['group' => $isGroup, 'select' => $select, 'int'=> $int, 'go' => 'prev', 'y' => $year]) }}" class="btn btn-primary">Vorige</a>
   		</div>
   		@endif
   		<div class="col-10 d-flex justify-content-center">
	       <ul style="list-style: none;">
	           <li style="display: inline-block;"><a class="btn btn-primary" href="{{ $dayUrl }}">Dag</a></li>
	           <li style="display: inline-block;"><a class="btn btn-primary" href="{{ $weekUrl }}">Week</a></li>
				@if($isGroup === 'GRP' || $isGroup === 'ALL')
		           <li style="display: inline-block;" ><a class="btn btn-primary" href="{{ $monthUrl }}">Maand</a></li>
				@endif
	           <li style="display: inline-block;"><a class="btn btn-primary" href="{{ $allUrl }}">Alle</a></li>
	       </ul>
       </div>
       @if ($select != 's')

       <div class="col-1">
   			<a href="{{ route('change', ['group' => $isGroup, 'select' => $select, 'int'=> $int, 'go' => 'next', 'y' => $year]) }}" class="btn btn-primary float-left">Volgende</a>
       </div>
       @endif

    </div>





@endsection