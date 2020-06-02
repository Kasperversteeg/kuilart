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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('desktop.components.nav')
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
