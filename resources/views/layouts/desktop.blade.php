<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kuilart') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- for tests --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        {{-- //////////////////////////////////   Start Menu   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ --}}
        <nav class="bg-light navbar navbar-expand-md border-bottom">
            <div class="container">

                {{-- eventueel menu toggler --}}
                {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown has-dropdown" id='jquery'>
                          <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{URL::asset('/img/menu-plus.png')}}">
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown" id='jquery2'>
                            <a class="dropdown-item" href="/reservations/create">Reservering</a>
                            <a class="dropdown-item" href="#">Bowlingbaan</a>
                          </div>
                        </li>
                        <li class="nav-item border-right border-left">
                            <a class="nav-link" href="{{ route('all',  'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}"><img style="margin-top:2px" src="{{URL::asset('/img/menu-overzicht.png')}}"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('showRestaurant', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}"><img src="{{URL::asset('/img/menu-restaurant.png')}}"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('showGroups', 'd='.\Carbon\Carbon::now()->isoFormat('Y-MM-DD')) }}">Groepen</a>
                        </li>
                     </ul>


                    <a class="navbar-brand" href="{{ route('home') }}">
                        {{ config('app.name', 'Kuilart') }}
                    </a>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
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
        {{-- //////////////////////////////////  End Menu   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ --}}


        {{-- //////////////////////////////////  Start Content   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ --}}
        <main class="content">
            <div class="container pt-2">

            {{-- submenu for overview --}}
            @yield('submenu')

            {{-- any content for desktop --}}
            @yield('content')

            </div>

        </main>

    @component('desktop.reservations.modalCreate')

    @endcomponent

        {{-- //////////////////////////////////  End Content   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ --}}
        

        {{-- //////////////////////////////////  Scripts   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ --}}
        @stack('scripts')
    </div>

</body>

</html>
