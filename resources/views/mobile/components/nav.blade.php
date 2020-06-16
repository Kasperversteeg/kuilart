{{-- //////////////////////////////////   Start Menu   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ --}}
<nav class="bg-light navbar navbar-expand-md border-top fixed-bottom p-0">
            <!--  Navbar content -->
        <ul class="navbar-nav mobile-nav w-100">
            <li class="nav-item mobile-nav-item border-left">
                <a class="nav-link {{ (request()->segment(2) == 'all') ? 'active' : '' }}" id="overzicht" href="{{ route('all.index',  'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">
                    <x-icon icon="overzicht" height='34px' width="34px" />
                </a>
            </li>
            <li class="nav-item mobile-nav-item border-left">
                <a class="nav-link {{ (request()->segment(2) == 'group') ? 'active' : '' }}" href="{{ route('groups.index', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">
                    <x-icon icon="groep" height='34px' width="34px" />
                </a>
            </li>
            <li class="nav-item mobile-nav-item border-left">
                <a class="nav-link {{ (request()->segment(2) == 'restaurant') ? 'active' : '' }}" href="{{ route('restaurants.index', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">
                    <x-icon icon="restaurant" height='34px' width="34px" />
                </a>
            </li>
            <li class="nav-item mobile-nav-item border-left">
                <a class="nav-link {{ (request()->segment(2) == 'restaurant') ? 'bowling' : '' }}" href="{{ route('bowling.index', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">
                    <x-icon icon="bowling" height='34px' width="34px" />
                </a>
            </li>
            <li class="nav-item mobile-nav-item border-left">
                <a class="nav-link pr-0" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <x-icon icon="logout" height='34px' width="34px" />
                </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
         </ul>
</nav>