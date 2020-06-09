{{-- show reservations for restaurant component--}}

<div class="row reservation-day-list mb-2 p-2">
	<div class="col-md-2 border-right d-flex align-items-center justify-content-center">
		<p>{{ date('H:i', strtotime($reservation->startTime)) }}</p>
	</div>

	<div class="col-md-6 d-flex">
		<div class="container reservation-day-name align-self-center">
			<div class="row">
				<div class="col-12">
					<h4 class='mb-0'>
						<a href="#" @click="editReservation({{ $reservation->id }})">{{ $reservation->name }}</a>
					</h4>
				</div>
				<div class="col-12"> 
					<p>Omschrijving</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2 d-flex align-items-center justify-content-end pr-1">
		<p>{{ $reservation->size }} </p>
	</div>	
	<div class="col-md-1 d-flex align-items-center justify-content-start pl-0">
		<p>Personen</p>
	</div>	
	<div class="col-md-1 d-flex">
		
	</div>
	<hr />
</div>
