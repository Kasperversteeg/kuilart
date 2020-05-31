{{-- Foreach restaurant reservation in the day object --}}
<div class="col-12 res-wrapper mb-4">
	<div class="col-12">
		<p class="font-weight-bold mb-0 border-bottom">Restaurant</p>
	</div>	
	@foreach($object->res as $res)
		<div class="row pl-3">
			<div class="col-md-10"> 
				<a href="{{ route('reservations.edit',$res->id)}} ">{{ $res->name }}</a>
			</div>
			<div class="col-md-1"> 
				<p>{{ date('H:i', strtotime($res->startTime)) }}</p>
			</div>
			<div class="col-md-1"> 
				<p>{{ $res->size }} P</p>
			</div>
		</div>
	@endforeach						
</div>	