{{-- //////////////////////////////////   Start Menu   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ --}}
<nav class="bg-light navbar navbar-expand-md border-top fixed-bottom px-0">
            <!--  Navbar content -->
        <ul class="navbar-nav mobile-nav w-100">
            <li class="nav-item mobile-nav-item dropdown has-dropdown" id='nav-add'>
                  <a class="nav-link p-1 pr-2 pt-2 active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <x-icon icon="plusje" height='34px' width="34px"  class="test"/>
                  </a>
                  <div class="dropdown-menu mobile-dropdown-menu" aria-labelledby="navbarDropdown" id='nav-dropdown'>
                    <a class="dropdown-item mobile-dropdown-item" href="{{ route('groups.create') }}">Groep</a>
                <div class="dropdown-divider"></div>                            
                    <a class="dropdown-item mobile-dropdown-item" href="{{ route('reservations.create') }}">Restaurant</a>
                <div class="dropdown-divider"></div>
                    <a class="dropdown-item mobile-dropdown-item" href="{{ route('bowling.index', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">Bowlingbaan</a>
                  </div>
                </li>
            <li class="nav-item mobile-nav-item border-left">
                <a class="nav-link" id="overzicht" href="{{ route('all.index',  'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">
                    <x-icon icon="overzicht" height='34px' width="34px" />
                </a>
            </li>
            <li class="nav-item mobile-nav-item border-left">
                <a class="nav-link" href="{{ route('groups.index', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">
                    <x-icon icon="groep" height='34px' width="34px" />
                </a>
            </li>
            <li class="nav-item mobile-nav-item border-left">
                <a class="nav-link" href="{{ route('restaurants.index', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">
                    <x-icon icon="restaurant" height='34px' width="34px" />
                </a>
            </li>
            <li class="nav-item mobile-nav-item border-left">
                <a class="nav-link" href="{{ route('bowling.index', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">
                    <x-icon icon="bowling" height='34px' width="34px" />
                </a>
            </li>
         </ul>
</nav>