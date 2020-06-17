<div class="mb-2 grp-week-wrapper p-2 grp-reservation container"> 
	<div class="row">
		<div class="col">
			<p class="grp-time">{{ date('H:i', strtotime($reservation->startTime)) }}</p>
		</div>
	</div>		
	<div class="row reservation-name">
		<div class="col">
			<a class="grp-link" href="#" @click="editGroup({{ $reservation->id }})">{{$reservation->name}}</a>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<p class="grp-size">{{$reservation->size}} personen</p>
		</div>
	</div>
	{{-- activities --}}
	<div class="container grp-day-activity">
		@foreach($reservation->activities as $activity)
			<div class="row pt-1">
				<div class="col-md-3 p-0 d-flex align-items-center grp-border-right">
					<p>{{ date('H:i', strtotime($activity->startTime)) }}</p>
				</div>
				<div class="col-md-9">
					<p>{{ $activity->description }}</p>
				</div>
			</div>

		@endforeach
	</div>
</div>