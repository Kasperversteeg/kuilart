@php
    $link = 'editGroup';
    if($reservation->type === 'RES'){
        $link = 'editReservation';
    }
@endphp
<div class="month-wrapper {{ $reservation->type === 'GRP'? 'grp-reservation' : 'res-reservation'}} row mx-1">
    <div class="col-10">
        <a class="month-view-link" href="#" @click="{{$link}}({{ $reservation->id }})">{{ $reservation->name }}</a>
    </div>
    <div class="col-2 px-0 d-flex justify-content-center">
        <p class="mb-0 month-view-size">{{ $reservation->size }}</p>
    </div>
</div>

