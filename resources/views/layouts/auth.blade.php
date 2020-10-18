<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield("title", "")</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-light bg-white shadow-sm py-3">
            <div class="container d-flex justify-content-center align-items-center">
                <a href="{{ route('home') }}" class="text-dark text-decoration-none">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/logos/instagram_logo.png') }}" alt="Instagram Logo" style="width: 20px">
                        <h4 class="m-0">&nbsp;|&nbsp;</h4>
                        <h4 style="margin: 1px 0 0 0">
                            {{ config('app.name', 'Instagram Clone') }}
                        </h4>
                    </div>
                </a>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
