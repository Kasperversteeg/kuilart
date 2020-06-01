
<a class="month-view-link {{ $reservation->type === 'GRP'? 'month-grp' : ''}}" href="{{ route('reservations.edit',$reservation->id)}} ">{{ $reservation->name }}</a>

