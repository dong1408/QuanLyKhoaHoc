<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hệ thống hỗ trợ nhập học online - Trường Đại học Sài Gòn') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free-5.14.0-web/css/all.css') }}" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/statusbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <style>
        /* Set up scrollbar for div.content-scroll */
        div.content-scroll::-webkit-scrollbar { width: 5px; } /* width */
        div.content-scroll::-webkit-scrollbar-track { background: #f1f1f1; } /* Track color */
        div.content-scroll::-webkit-scrollbar-thumb { background: #888; } /* Handle color */
        div.content-scroll::-webkit-scrollbar-thumb:hover { background: #555; } /* Handle on hover */
        
        /* Set up the width and height of div.content-scroll */
        .bottom-scroll {
            /* border: 1px solid #CCC; */
            display: inline-block;
            overflow: hidden;
            height: 70vh;
            width: 100%;
            /* border-radius: 20px; */
        }
        .bottom-content-scroll {
            max-height: 80vh;
            height: 70vh;
            overflow-y: scroll;
            padding: 15px;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm p-0">
            <div class="container-fluid pl-2">
                <a class="navbar-brand font-weight-bold text-lg-left" href="{{ url('/home') }}" style="color:#105582; font-size: 20px;
                    font-family: Arial; width: 250px;">
                        <img src="{{ asset('img/logo.svg') }}" style = "width: 20%;"/>
                    {{ config('app.name', 'Hệ thống hỗ trợ nhập học') }}
                </a>

                {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest

                        @else
                            <li class="nav-item dropdown pl-3">
                                <span class = "font-weight-bold"> {{ Auth::user()->name }} </span>
                                <span> &nbsp | </span>
                                <a class="text-decoration-none" href="{{ url('/home') }}">
                                    <i class=" fas fa-home"></i> {{ __('Trang chủ ') }}
                                </a>
                                <span> &nbsp | </span>
                                <a class="" href="{{ route('passwordchange') }}">
                                    <i class="fas fa-key    "></i> {{ __('Đổi mật khẩu ') }}
                                </a>
                                <span> &nbsp |  &nbsp</span>
                                <a class="text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                     {{ __('Thoát ') }}  <i class="fas fa-sign-out-alt    "></i>
                                </a>
                
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    {{-- <script src="{{ asset('js/statusbar.js') }}" defer></script> --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @yield('scripts')
</body>
</html>
