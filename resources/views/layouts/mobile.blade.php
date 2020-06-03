<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Kuilart') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app-mobile.js') }}" defer></script>
    {{-- for tests --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <main class="content">
            <div class="container pt-2">
                {{-- submenu for overview --}}
                @yield('submenu')
                {{-- any content for mobile --}}
                @yield('content')
            </div>
        </main>
        <div class="clear-nav"></div>
        {{-- fixed bottom nav for mobile users --}}
        @include('mobile.components.nav')

        @stack('scripts')
    </div>

</body>
</html>
