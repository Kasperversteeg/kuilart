@extends('layouts.desktop')

@section('title')
	<h1 class= "py-4">Home</h1>
@endsection

@section('content')
<div class="container bg-white">
	<div class="row pt-2">
		<div class="col-12">
		<h1>Welcome {{ Auth::user()->name }} </h1>
		<p>Het is vandaag {{ ucfirst($now->dayName) . ' ' .$now->toDateString() }}</p>
		</div>
	</div>

	<button  @click="showModal" >test</button>
	<button  @click="toggleModal('Group')" >test</button>

	@php
		$reservationType = 'GRP';
		$title = 'Voeg groepsreservering toe';
		$false = 'true';
		$reservationId = 1;
	@endphp

	<add reservation-type="{{ $reservationType }}" title='{{ $title }}'  :editing="{{ $false }}"  :id="{{ $reservationId }}"  @open='showModal'></add>


</div>
@endsection
