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

        <main class="content">
            <div class="container-fluid container-submenu">
                {{-- submenu for overview --}}
                @yield('submenu')
                <div class="container">
                    @yield('title')
                </div>
            </div>
            <div class="container-fluid bg-white container-main">
                {{-- any content for desktop --}}
                @yield('content')
            </div>
        </main>

        <res v-show="resModalShowing" @close="toggleRes" ></res>
        <grp v-show="grpModalShowing" @close="toggleGrp"></grp>
        
        <flash-message class="flash-box" transition-name="slide"></flash-message>
        

        @stack('scripts')
    </div>
</body>
</html>
