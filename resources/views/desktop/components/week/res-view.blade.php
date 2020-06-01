<div class="mb-2 res-week-wrapper p-2 border-res"> 
	<div class="row reservation-name">
		<div class="col-sm-12">
			<a href="{{ route('reservations.edit',$reservation->id)}} ">{{$reservation->name}}</a>
		</div>
	</div>
	<div class="row reservation-attributes">
		<div class="col-md">
			<p>{{ date('H:i', strtotime($reservation->startTime)) }}</p>
		</div>
		<div class="col-md d-flex justify-content-end">
			<p>{{$reservation->size}}P</p>
		</div>
	</div>
</div>
