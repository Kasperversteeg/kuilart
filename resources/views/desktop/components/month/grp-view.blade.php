<div class="month-wrapper {{ $reservation->type === 'GRP'? 'grp-reservation' : 'res-reservation'}}">
    <a class="month-view-link " href="#" @click="editGroup({{ $reservation->id }})">{{ $reservation->name }}</a>
</div>

