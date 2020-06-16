{{-- show reservations for grp component--}}
@php
	$bool = false;
@endphp
<div class="container p-2">
	<div class="col-1">
		@foreach($times as $time)
			<div class="row border" style= "height: 50px">
				{{$time}}
			</div>
		@endforeach
	</div>



</div>