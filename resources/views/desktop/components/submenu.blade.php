@section('submenu')
	{{-- create submenu for type --}}
@php
	$now = \Carbon\Carbon::now();

	switch($isGroup){
		case('RES'):
			$route = 'restaurants.index';
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
<div class="container py-4">
   <div class="row nav-sub-menu justify-content-center"> 
	   {{-- period submenu --}}
   		<div class="col-12 d-flex justify-content-center submenu-period">
	       <ul>
	           <li><a class="btn btn-white {{ $select === 'd' ? 'active' : '' }}" href="{{ $dayUrl }}">Dag</a></li>
	           <li><a class="btn btn-white {{ $select === 'w' ? 'active' : '' }}" href="{{ $weekUrl }}">Week</a></li>
				@if($isGroup === 'GRP' || $isGroup === 'ALL')
		           <li><a class="btn btn-white {{ $select === 'm' ? 'active' : '' }}" href="{{ $monthUrl }}">Maand</a></li>
				@endif
	           <li><a class="btn btn-white {{ $select === 's' ? 'active' : '' }}" href="{{ $allUrl }}">Alle</a></li>
	       </ul>
       </div>
	</div>
	
	{{-- title of current page --}}
	<div class="row justify-content-center">
		<h1 class="pb-1">{{ $title }}reserveringen</h1>
	</div>

		{{-- date, previous and next buttons --}}
	<div class="row justify-content-md-center">
			
		@if ($select != 's')
			<div class="col-1">
				<a href="{{ route('change', ['group' => $isGroup, 'select' => $select, 'int'=> $int, 'go' => 'prev', 'y' => $year]) }}" class="btn btn-img">
					<x-icon icon="arrow-left" height='34px' width="34px" />
				</a>
			</div> 
		@endif
			
		<div class="col-2 justify-content-center submenu-showing">
			<h3 class="d-flex justify-content-center">{{ $showing }}</h3> 
			<h5 class="d-flex justify-content-center {{$select === 'w' ? 'submenu-smaller-period' : '' }}">{{ $period ? $period : $year }}</h5>
		</div>	
			
		@if ($select != 's')
			<div class="col-1">
				<a href="{{ route('change', ['group' => $isGroup, 'select' => $select, 'int'=> $int, 'go' => 'next', 'y' => $year]) }}" class="btn btn-img float-left">
					<x-icon icon="arrow-right" height='34px' width="34px" />
				</a>
			</div>
		@endif
	</div>
	@if($isGroup === 'GRP' && $select === 'd')
		<div class="col-md-4 d-flex justify-content-end align-items-end">
			<a href="{{route('groups.index', ['d' => $day->date , 'bar' => false])}}" class="btn btn-white">Lijst</a>
			<a href="{{route('groups.index', ['d' => $day->date , 'bar' => true])}}" class="btn btn-white">Balk</a>
		</div>
	@endif
</div>





@endsection