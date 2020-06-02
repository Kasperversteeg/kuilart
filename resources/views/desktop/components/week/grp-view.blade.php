@php
	$bool = false;
@endphp
<div class="mb-2 res-week-wrapper p-2 border-grp container"> 
	<div class="row reservation-name">
		<div class="col-md-9">
			<a href="{{ route('groups.edit',$reservation->id)}} ">{{$reservation->name}}</a>
		</div>
		<div class="col-md-3 p-0 pr-1 week-grp-size">
			<p>{{$reservation->size}}P</p>
		</div>
	</div>

	<div class="container reservation-attributes">
		@foreach($reservation->activities as $activity)
			@php
				if($bool){
					$bool = false;
				} else {
					$bool = true;
				}
			@endphp

			<div class="row {{ $bool ? '' : 'bg-gray' }} activity-row">
				<div class="col-md-4 border-right p-0 activity-time d-flex align-items-center">
					<p>{{ date('H:i', strtotime($activity->startTime)) }}</p>
				</div>
				<div class="col-md-8 p-0 pl-1">
					{{ $activity->description }}
				</div>
			</div>
		@endforeach
	</div>
</div>
