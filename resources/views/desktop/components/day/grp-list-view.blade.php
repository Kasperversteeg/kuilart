{{-- show reservations for grp component--}}
@php
	$bool = false;
@endphp
<div class="row mb-2 p-2 border">
	{{-- title left and persons right --}}
	<div class="col-sm-8">
		<div class="container group-day-list">
			<div class="row pt-2">
				<div class="col-sm-8">
					<h4><a href="{{ route('reservations.edit',$reservation->id)}} ">{{ $reservation->name }}</a></h4>
				</div>
				<div class="col-sm-4 d-flex justify-content-end">
					<p class="font-weight-bold">{{ $reservation->size }} P.</p>
				</div>
			</div>
			{{-- activities --}}
			<div class="container">
				@foreach($reservation->activities as $activity)
				@php
					if($bool){
						$bool = false;
					} else {
						$bool = true;
					}

				@endphp
					<div class="row {{ $bool ? '' : 'bg-gray' }}">
						<div class="col-md-3">
							<p>{{ date('H:i', strtotime($activity->startTime)) }} - {{ date('H:i', strtotime($activity->endTime)) }}</p>
						</div>
						<div class="col-md-7">
							{{ $activity->description }}
						</div>
						<div class="col-md-2 d-flex justify-content-end">
							{{ $activity->size }}
						</div>
					</div>

				@endforeach
			</div>
		</div>
	</div>
	<div class="col-sm-4 bg-gray p-2">
		{{ $reservation->notes }}
	</div>
	

</div>