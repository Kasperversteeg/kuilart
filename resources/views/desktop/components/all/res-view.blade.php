{{-- show reservations for restaurant component--}}

<div class="row reservation-day-list res-reservation mb-2 p-2">
	<div class="col-md-2 res-border-right d-flex align-items-center justify-content-center">
		<p class="res-time-day">{{ date('H:i', strtotime($reservation->startTime)) }}</p>
	</div>

	<div class="col-md-7 d-flex ">
		<div class="container reservation-day-name align-self-center">
			<div class="row res-border-right">
				<div class="col-12">
					<h4 class='mb-0'>
						<a class="res-link" href="#" @click="editReservation({{$reservation->id }})">{{ $reservation->name }}</a>
					</h4>
				</div>
				<div class="col-12"> 
					<p class="res-notes">{{$reservation->notes}}</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2 d-flex align-items-center justify-content-center res-border-right">
		<p>{{ $reservation->size }} Personen</p>
	</div>	
	<div class="col-md-1 res-day-table d-flex align-items-center">
			<div class="container">
			<div class="col-12 d-flex justify-content-center">
				<p>Tafel</p>
			</div>
			<div class="col-12 d-flex justify-content-center">
			<p>{{ $reservation->tableNr ? '#'.$reservation->tableNr : '-' }}</p>
			</div>
		</div>
	</div>
	<hr />
</div>
