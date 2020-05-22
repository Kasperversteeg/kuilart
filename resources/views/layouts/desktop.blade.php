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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md">
            <div class="container">

                {{-- eventueel menu toggler --}}
                {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li>Menu hier</li>
                    </ul>


                    <a class="navbar-brand" href="{{ url('/home') }}">
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

        <main class="content">

            <div class="container pt-2">
               <div class="row justify-content-center"> 
                   <ul style="list-style: none;">
                       <li style="display: inline-block;"><a class="btn btn-primary" href="/reservations/show/day">Day</a></li>
                       <li style="display: inline-block;"><a class="btn btn-primary" href="/reservations/show/week">Week</a></li>
                       <li style="display: inline-block;" ><a class="btn btn-primary" href="/reservations/show/month">Month</a></li>
                       <li style="display: inline-block;"><a class="btn btn-primary" href="/reservations/show/all">All</a></li>
                   </ul>
                </div>
           
         {{-- make modal view with vue --}}
          {{--   <div id="modal">
                <card-modal :showing="modalShowing" @close="modalShowing = false" >
                    <h2>Example modal</h2>
                    <p>This is example text passed through to the modal via a slot.</p>
                </card-modal>
            </div> --}}

            @yield('content')

            </div>

        </main>
    </div>
</body>
</html>
