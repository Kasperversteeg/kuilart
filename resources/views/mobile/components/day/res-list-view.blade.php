{{-- show reservations for restaurant component--}}
<div class="container mb-2 p-2 res-reservation">
	<div class="row reservation-day-list mb-2 p-2 border-res">
		<div class="col-9 d-flex align-items-center">
			<h3><a class="res-link" href="{{ route('reservations.edit',$reservation->id)}} ">{{ $reservation->name }}</a></h3>
		</div>
		<div class="col-3">
			<form method="post" action="{{ route('updateTableNr', $reservation->id) }}">
	          @csrf
				<div class="form-group">  
					<label class="w-100 text-center" for="tableNr"><small>Tafel</small></label>
		            <input type="text" onchange="this.form.submit()" class="form-control input-text-align-center {{  $errors->has('tableNr') ? 'form-input-invalid' : ''}} " name="tableNr" placeholder="nr" value='{{ $reservation->tableNr}}'/>
		        </div>
		    </form>
		</div>

		<div class="col-3 border-right d-flex justify-content-center pt-2">
			<p>{{ date('H:i', strtotime($reservation->startTime)) }}</p>
		</div>
		<div class="col-9 pt-2">
			<p>{{ $reservation->size }} Personen</p>
		</div>	
		<div class="col-12 pt-2"> 
			<p>Opmerkingen</p>
		</div>
	</div>
</div>