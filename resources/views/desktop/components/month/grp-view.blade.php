
<a class="month-view-link {{ $reservation->type === 'GRP'? 'month-grp' : 'month-res'}}" href="{{ route('groups.edit',$reservation->id)}} ">{{ $reservation->name }}</a>

