<nav class="bg-light navbar navbar-expand-md py-0">
    <div class="container" id="nav-container">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav col-5">
                <li class="nav-item">
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
            <!-- App title -->
            <div class="navbar-nav col-2 justify-content-center px-0">
                <a class="navbar-brand mr-0" href="{{ route('home') }}">
                    {{ config('app.name', 'Kuilart') }}
                </a>                
            </div>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav col-5 justify-content-end pr-0">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                
                @else
                <li class="nav-name d-flex align-items-center">{{ Auth::user()->name }}</li>
                <li class="nav-item">
                    <a class="logout nav-link pr-0" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <x-icon icon="logout" height='34px' width="34px" />
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