
<a class="month-view-link {{ $reservation->type === 'GRP'? 'month-grp' : 'month-res'}}" href="#" @click="editGroup({{ $reservation->id }})">{{ $reservation->name }}</a>

