<div class="mb-2 res-week-wrapper p-2 res-reservation container"> 
	<div class="row">
		<div class="col">
			<p class="res-time">{{ date('H:i', strtotime($reservation->startTime)) }}</p>
		</div>
	</div>		
	<div class="row reservation-name">
		<div class="col">
			<a class="res-link" href="#" @click="editReservation({{ $reservation->id }})">{{$reservation->name}}</a>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<p class="res-size">{{$reservation->size}} personen</p>
		</div>
	</div>
</div>
