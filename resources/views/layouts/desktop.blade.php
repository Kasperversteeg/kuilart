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
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    
</head>
<body>
    <div id="app">
        @include('desktop.components.nav')

        <main class="content">
            <div class="container-fluid container-submenu">
                {{-- submenu for overview --}}
                @yield('submenu')
            </div>
            <div class="container-fluid bg-white container-main">
                {{-- any content for desktop --}}
                @yield('content')
            </div>
        </main>

        <modal v-show='modalShowing' @close='closeModal'></modal>        
        <flash-message class="flash-box" transition-name="slide"></flash-message>
        
        @stack('scripts')
    </div>
</body>
</html>
