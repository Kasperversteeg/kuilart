

{{-- //////////////////////////////////   Start Menu   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ --}}
<nav class="bg-light navbar navbar-expand-md border-bottom">
    <div class="container" id="nav-container">

        {{-- eventueel menu toggler --}}
        {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button> --}}

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav col-5">
                <li class="nav-item dropdown has-dropdown" id='nav-add'>
                  <a class="nav-link p-1 pr-2 pt-2" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <x-icon icon="plusje" height='34px' width="34px"  class="test"/>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown" id='nav-dropdown'>
                    <a class="dropdown-item" href="{{ route('groups.create') }}">Groep</a>                            
                    <a class="dropdown-item" href="{{ route('reservations.create') }}">Restaurant</a>
                    <a class="dropdown-item" href="{{ route('bowling.index', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">Bowlingbaan</a>
                  </div>
                </li>
                <li class="nav-item border-left">
                    <a class="nav-link {{ (request()->segment(2) == 'all') ? 'active' : '' }}" id="overzicht" href="{{ route('all.index',  'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">
                        <x-icon class="icon-active" icon="overzicht" height='34px' width="34px" />
                    </a>
                </li>
                <li class="nav-item border-left">
                    <a class="nav-link {{ (request()->segment(2) == 'group') ? 'active' : '' }}" href="{{ route('groups.index', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">
                        <x-icon icon="groep" height='34px' width="34px" />
                    </a>
                </li>
                <li class="nav-item border-left">
                    <a class="nav-link {{ (request()->segment(2) == 'restaurant') ? 'active' : '' }}" href="{{ route('restaurants.index', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">
                        <x-icon icon="restaurant" height='34px' width="34px" />
                    </a>
                </li>
                <li class="nav-item border-left">
                    <a class="nav-link {{ (request()->segment(1) == 'bowling') ? 'active' : '' }}" href="{{ route('bowling.index', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">
                        <x-icon icon="bowling" height='34px' width="34px" />
                    </a>
                </li>
             </ul>

            <div class="navbar-nav col-2 justify-content-center">
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('app.name', 'Kuilart') }}
                </a>                
            </div>


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav col-5 justify-content-end">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                   
                @else
                    <li>{{ Auth::user()->name }}</li>
                    <li id="nav-spacer">/</li>
                    <li>
                        <a class="logout" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <span>{{ __('Logout') }}</span>
                        </a>
                    </li>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </ul>
        </div>
    </div>
</nav>