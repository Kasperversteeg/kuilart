{{-- show reservations for grp component--}}

<div class="row reservation-full mb-2 p-2 border">

	<div class="pt-2 col-md-7"> 
		<h4><a href="{{ route('reservations.edit',$reservation->id)}} ">{{ $reservation->name }}</a></h4>
	</div>
	<div class="pt-2 col-md-3">
		<div class="row">
			<div class="col-sm-8 d-flex justify-content-end">
				<p>Aantal personen:</p>
			</div>
			<div class="col-sm-4">
				<p>{{ $reservation->size }}</p>
			</div>
		</div>
		
	</div>
	

	
	<hr />
</div>