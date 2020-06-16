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
	<div class="col-md-1 d-flex">
		<form method="post" action="{{ route('updateTableNr', $reservation->id) }}">
          @csrf
			<div class="form-group">  
				<label class="w-100 text-center" for="tableNr"><small>Tafel</small></label>
	            <input type="text" onchange="this.form.submit()" class="form-control input-text-align-center {{  $errors->has('tableNr') ? 'form-input-invalid' : ''}} " name="tableNr" placeholder="nr" value='{{ $reservation->tableNr}}'/>
	        </div>
	    </form>
	</div>
	<hr />
</div>
