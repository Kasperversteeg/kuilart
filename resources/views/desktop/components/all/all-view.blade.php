@php
	$grpBG = true;
	$resBG = false;		
@endphp

<div class="container">
	<div class="row">
		<div class="col-md-6">
			<h5 class="font-weight-bold">Groepen</h5>
		</div>
		<div class="col-md-6">
			<h5 class="font-weight-bold">Restaurant</h5>
		</div>
		
		<div class="col-md-6 border-right p-2">		
		{{-- insert groups in left column  --}}		
			<div class="container group-container">
				@foreach($groups as $group)		
					@php
						if($grpBG === false){
							$grpBG = true;
						} else {
							$grpBG = false;
						}
					@endphp
					<div class="row p-2 {{ $grpBG ? 'bg-gray' : 'bg-white' }}">
						<div class="col-3 border-right">
							<p>{{ date('H:i', strtotime($group->startTime)) }}</p>
						</div>
						<div class="col-6">
							<a href="#" @click="editGroup({{ $group->id }})">{{ $group->name }}</a>
						</div>
						<div class="col-3 d-flex justify-content-end pr-0">
							<p >{{ $group->size }} Personen</p>
						</div>
					</div>
					
				@endforeach
			</div>
		</div>
		<div class="col-md-6 p-2 ">	
		{{-- restaurant reservations in the right column	 --}}
			<div class="container res-container">
				@foreach($res as $res)
					@php
						if($resBG === false){
							$resBG = true;
						} else {
							$resBG = false;
						}
					@endphp
					<div class="row p-2 {{ $resBG ? 'bg-gray' : 'bg-white' }}">
						<div class="col-3 border-right">
							<p>{{ date('H:i', strtotime($res->startTime)) }}</p>
						</div>
						<div class="col-7">
							<a href="#" @click="editReservation({{ $reservation->id }})">{{ $res->name }}</a>
						</div>
						<div class="col-2 d-flex justify-content-end pr-0">
							<p>{{ $res->size }} Pers</p>
						</div>
					</div>
				@endforeach

			</div>
		</div>

	</div>
</div>