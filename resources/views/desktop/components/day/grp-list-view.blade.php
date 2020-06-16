{{-- show reservations for grp component--}}
<div class="row mb-2 p-2 grp-reservation">
	{{-- title left and persons right --}}
	<div class="col-sm-8">
		<div class="container grp-border-right">
			<div class="row pb-1">
				<div class="col-sm-8 grp-border-bottom">
					<h4 class="mb-1"><a class="grp-link" href="#"  @click="editGroup({{ $reservation->id }})">{{ $reservation->name }}</a></h4>
				</div>
				<div class="col-sm-4 d-flex justify-content-end">
					<p class="grp-day-size mb-0">{{ $reservation->size }} P.</p>
				</div>
			</div>
			{{-- activities --}}
			<div class="container grp-day-activity">
				@foreach($reservation->activities as $activity)
					<div class="row pt-1">
						<div class="col-md-3 d-flex align-items-center grp-border-right">
							<p>{{ date('H:i', strtotime($activity->startTime)) }} - {{ date('H:i', strtotime($activity->endTime)) }}</p>
						</div>
						<div class="col-md-7">
							<p>{{ $activity->description }}</p>
						</div>
						<div class="col-md-2 d-flex justify-content-end">
							{{ $activity->size }}
						</div>
					</div>

				@endforeach
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="container">
			<div class="row grp-border-bottom">
				<h5 class="mb-1">Opmerkingen</h5>
			</div>
			<div class="row">
				<p>{{ $reservation->notes }}</p>
			</div>
		</div>
	</div>
	

</div>