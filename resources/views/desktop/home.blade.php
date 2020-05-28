@extends('layouts.desktop')

@section('content')
	
	<div class="row pt-2">
		<div class="col-12">
		<h1>Welcome {{ Auth::user()->name }} </h1>
		<p>Het is vandaag {{ ucfirst($now->dayName) . ' ' .$now->toDateString() }}</p>
		</div>
	</div>
	


{{-- 	<div class="test">
		<h1>Test</h1>
		<a href="#modal">Open modal</a>
	</div>
	
	<modal name="modal">
		<h1>modal view</h1>
	</modal>
 --}}
@endsection
