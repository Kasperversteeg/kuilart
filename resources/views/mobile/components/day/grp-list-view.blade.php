{{-- show reservations for grp component--}}
@php
	$bool = false;
@endphp
<div class="container mb-2 p-2 border-grp group-day-list">
	{{-- title left and persons right --}}
			<div class="row pt-2">
				<div class="col-10">
					<h4><a href="{{ route('groups.edit', $reservation->id)}} ">{{ $reservation->name }}</a></h4>
				</div>
				<div class="col-2 pl-0 pr-1">
					<p class="font-weight-bold">{{ $reservation->size }}<small> P.</small></p>
				</div>
			</div>
			{{-- activities --}}
			<div class="container">
				<div class="row">
					<div class="col-12 px-1">
						<p class="font-weight-bold">Activiteiten</p>
					</div>
				</div>
				@foreach($reservation->activities as $activity)
					@php
						$bool = $bool ? false : true;
					@endphp

					<div class="row {{ $bool ? '' : 'bg-gray' }}">
						<div class="col-12 px-1">
							<p>{{ date('H:i', strtotime($activity->startTime)) }} - {{ date('H:i', strtotime($activity->endTime)) }}</p>
						</div>
						<div class="col-8 px-1">
							{{ $activity->description }}
						</div>
						<div class="col-4 px-1 d-flex justify-content-end">
							<p>{{ $activity->size }} P.</p>
						</div>
					</div>

				@endforeach

			<div class="row bg-gray mt-2 px-1">
				<p class="font-weight-bold">Opmerkingen</p>
				<p>{{ $reservation->notes }}</p>
			</div>
			</div>
	

</div>