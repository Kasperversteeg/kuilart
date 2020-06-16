<div class="row">
	<div class="col-md-6 border-right pl-0">		
	{{-- insert groups in left column  --}}		
		<div class="container all-grp-container py-2">
			<h5 class="all-type-title">Groepen</h5>
			@foreach($groups as $group)		
			{{-- show reservations for group component--}}
			<div class="row reservation-day-list grp-reservation mb-2 p-2">
				<div class="col-md-2 grp-border-right d-flex align-items-center justify-content-center">
					<p class="grp-time-day">{{ date('H:i', strtotime($group->startTime)) }}</p>
				</div>
				<div class="col-md-7 d-flex align-items-center grp-border-right">
					<h4 class='mb-0'>
						<a class="grp-link" href="#" @click="editGroup({{$group->id }})">{{ $group->name }}</a>
					</h4>
				</div>
				<div class="col-md-3 d-flex align-items-center justify-content-center">
					<p class="grp-size">{{ $group->size }} Personen</p>
				</div>	
			</div>
			@endforeach
		</div>
	</div>
	<div class="col-md-6 pr-0">	
	{{-- restaurant reservations in the right column	 --}}
		<div class="container all-res-container py-2">
			<h5 class="all-type-title">Restaurant</h5>
			@foreach($res as $res)
				{{-- show reservations for restaurant component--}}
				<div class="row reservation-day-list res-reservation mb-2 p-2">
					<div class="col-md-2 res-border-right d-flex align-items-center justify-content-center">
						<p class="res-time-day">{{ date('H:i', strtotime($res->startTime)) }}</p>
					</div>
					<div class="col-md-7 d-flex align-items-center res-border-right">
						<h4 class='mb-0'>
							<a class="res-link" href="#" @click="editReservation({{$res->id }})">{{ $res->name }}</a>
						</h4>
					</div>
					<div class="col-md-3 d-flex align-items-center justify-content-center">
						<p class="res-size">{{ $res->size }} Personen</p>
					</div>	
				</div>
			@endforeach
		</div>
	</div>
</div>