
<a class="month-view-link {{ $reservation->type === 'GRP'? 'month-grp' : 'month-res'}}" href="{{ route('reservations.edit',$reservation->id)}} ">{{ $reservation->name }}</a>

