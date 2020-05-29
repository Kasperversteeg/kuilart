@extends('layouts.desktop')

@section('content')
	
	<div class="row pt-2">
		<div class="col-12">
		<h1>Welcome {{ Auth::user()->name }} </h1>
		<p>Het is vandaag {{ ucfirst($now->dayName) . ' ' .$now->toDateString() }}</p>
		</div>
	</div>
	


	<button type="button" class="btn" @click="showModal">
      Open Modal!
    </button>
	


@endsection
