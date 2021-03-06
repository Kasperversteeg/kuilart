<div class="col-md border day-column">
	<div class="row border-bottom p-2 -center day-column-header">
		<div class="col-12 justify-content-center d-flex">
			<h4><a href="{{ route('showAll', ['d'=> $date->date]) }}">{{ ucfirst($date->day) }}</a></h4> 
		</div>
		<div class="col-12 justify-content-center d-flex">
			<p>{{ date('d-m-y', strtotime($date->date)) }}</p>
		</div>
	</div>
	
	@forelse ($date->reservations as $reservation)

		<div class="pt-2 reservation-wrapper"> 
			<div class="row">
				<div class="col-sm-7">
					<a href="{{ route('reservations.edit',$reservation->id)}} ">{{$reservation->name}}</a>
				</div>
				<div class="col-sm">
					<p>{{$reservation->size}}P</p>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<p>{{ date('H:i', strtotime($reservation->startTime)) }}</p>
				</div>
			</div>
		</div>

	
	@empty
		<p>Nieks</p>
	@endforelse
</div>