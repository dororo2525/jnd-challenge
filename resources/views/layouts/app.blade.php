<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <style>
        .content {
            padding-top: 10px;
        }
    </style>
    @yield('style')
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark sticky-bottom">
                    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark min-vh-100">
                        <a href="/"
                            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-center text-white text-decoration-none">
                            <span class="fs-4">JND Challenge</span>
                        </a>
                        <hr>
                        <ul class="nav nav-pills flex-column mb-auto">
                            @if(Auth::check() && Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a href="#" class="nav-link text-white">
                                    <i class="bi me-2 bi-speedometer2"></i>
                                    Dashboard
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="#" class="nav-link text-white">
                                    <i class="bi me-2 bi-house"></i>
                                    Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link text-white">
                                    <i class="bi me-2 bi-link"></i>
                                    Shorten URL
                                </a>
                            </li>
                        </ul>
                        <hr>
                        <div class="dropdown">
                            <a href="#"
                                class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi me-2 bi-gear"></i>
                                <strong>Settings</strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow"
                                aria-labelledby="dropdownUser1">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Change password</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item"href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">Sign out</a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form> 
                                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                            <div class="container">
                                <a class="navbar-brand" href="{{ url('/') }}">
                                    @yield('title')
                                </a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <!-- Left Side Of Navbar -->
                                    <ul class="navbar-nav me-auto">

                                    </ul>

                                    <!-- Right Side Of Navbar -->
                                    <ul class="navbar-nav ms-auto">
                                        <!-- Authentication Links -->
                                        @guest
                                            @if (Route::has('login'))
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                                </li>
                                            @endif

                                            @if (Route::has('register'))
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                        href="{{ route('register') }}">{{ __('Register') }}</a>
                                                </li>
                                            @endif
                                        @else
                                            <li class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" v-pre>
                                                    {{ Auth::user()->name }}
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                                     document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                        class="d-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </li>
                                        @endguest
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="row">
                        @yield('content')
                    </div>
                </div>





            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    @yield('script')
</body>

</html>
