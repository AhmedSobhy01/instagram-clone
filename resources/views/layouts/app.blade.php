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
        <nav class="navbar navbar-light navbar-expand bg-white shadow-sm">
            <div class="container">
                <a href="{{ route('home') }}" class="text-dark text-decoration-none">
                    <div class="d-flex align-items-center">
                        <img src="https://image.flaticon.com/icons/png/512/87/87390.png" alt="Instagram Logo" style="width: 20px">
                        <h4 class="m-0 d-none d-md-block">&nbsp;|&nbsp;</h4>
                        <h4 class="d-none d-md-block" style="margin: 1px 0 0 0">
                            {{ config('app.name', 'Instagram Clone') }}
                        </h4>
                    </div>
                </a>

                <!-- Left Side Of Navbar -->
                <ul class="search-box navbar-nav mr-auto position-relative" style="margin-left: 25%">
                    <!-- search-->
                    <li class="nav-item d-flex align-items-center position-relative">
                        <search-bar placeholder={{ __('main.search') }} post-to={{ route('search') }}></search-bar>
                        <i class="fa fa-search position-absolute ml-2 ml-md-0 ml-md-2"></i>
                    </li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false"  aria-haspopup="true">
                            <i class="fas fa-user mr-1"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="{{ route('profile', auth()->user()->username) }}" class="dropdown-item">{{ __("main.profile") }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('main.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @else
                        <a href="{{ route("login") }}" class="btn btn-primary  mr-2">{{ __('main.login') }}</a>
                        <a href="{{ route("register") }}" class="btn btn-link">{{ __('main.register') }}</a>
                    @endauth
                </ul>

            </div>
        </nav>
        <main class="py-3">
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    @stack('bscripts')
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
