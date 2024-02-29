<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hệ thống hỗ trợ nhập học online - Trường Đại học Sài Gòn') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    {{-- <script src="{{ asset('js/jquery.min.js') }}"></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free-5.14.0-web/css/all.css') }}" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/statusbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="{{ asset('css/dataTables.min.css') }}" rel="stylesheet">

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
            /* height: 60vh; */
            width: 100%;
            /* border-radius: 20px; */
        }
        .bottom-content-scroll {
            /* max-height: 60vh;
            height: 60vh; */
            overflow-y: scroll;
            padding: 15px;
        }
        .table td {
            padding: .25rem !important;
        }
        .table td input {
            padding: 0 !important;
            text-align: center !important;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm p-0">
            <div class="container-fluid pl-2">
                <a class="navbar-brand font-weight-bold text-lg-left" href="{{ url('/home') }}" style="width: 250px;">
                    <img src="{{ asset('img/logo.svg') }}" style = "width: 20%;"/>
                    <span style ="color:#105582; font-size: 20px;font-family: Arial; ">
                        {{ config('app.name', 'Quản lý điểm thi') }}
                    </span>
                    <small class="text-muted" style="font-size:0.6em;"><em> (v.3.1)</em></small>
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
                                <a class="text-decoration-none" href="{{ route('passwordchange') }}">
                                    <i class="fas fa-key    "></i> {{ __('Đổi mật khẩu ') }}
                                </a>
                                <span> &nbsp |  &nbsp</span>
                                <a class="text-danger text-decoration-none" href="{{ route('logout') }}"
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 mb-2"> <!-- style="border-right: solid 1px #E7EAED" -->
                        <div class="card">
                            <div class="card-body">
                                @guest
                                <form method="POST" action="{{ route('login') }}" id = "login_form">
                                    @csrf
                                    <div class="form-row form-group d-flex justify-content-center">
                                        <label for="password">Mã cán bộ</label>
                                        <input id="username" placeholder="" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-row form-group d-flex justify-content-center">
                                        <label for="password"> Mật khẩu</label>
                                        <input id="password" placeholder = "" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                    <div class="form-row form-group d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Đăng nhập') }}
                                        </button>
                                    </div>
                                    <div class="form-row form-group d-flex justify-content-center">

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Quên mật khẩu?') }}
                                            </a>
                                        @endif
                                    </div>
                                </form>
                                @endguest
                                @if(Auth::user())
                                    <p>Họ tên GV: <span class = "text-primary">{{ Auth::user()->name }}</span> </p>
                                    <p>Mã số: <span class = "text-primary">{{ Auth::user()->username }}</span> </p>
                                    <p>Email: <span class = "text-primary">{{ Auth::user()->email }}</span> </p>
                                    {{-- <p>Đơn vị: <span class = "text-primary">{{ Auth::user()->khoa }}</span> </p>  --}}
                                @endif
                                @if(Route::currentRouteName() == 'home')
                                {{-- <hr>
                                <div class = "alert alert-warning">
                                    <p>Giảng viên chỉ thấy và thao tác được trên các nhóm thi mình chấm 1.</p>
                                </div> --}}
                                @endif
                                <hr>
                                <small class="text-muted">
                                    Phiên bản <a class="text-primary font-weight-bold" style = "text-decoration: none;" data-toggle="modal" data-target="#version_info">3.1 </a> cập nhật ngày 15/6/2022. <br>
                                </small>
                                
                                @if(Route::currentRouteName() == 'nhapdiem')
                                <div class="alert alert-danger" role="alert">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Hệ thống có hỗ trợ quy đổi khi nhập: 03 thành 0.3; 75 thành 7.5; 100 thành 10.
                                </div>
                                @endif
                                <!-- Modal version info -->
                                <div class="modal fade" id="version_info" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style = "font-size: 0.9em">
                                                <p class = "text-danger">Nội dung cập nhật phiên bản v3.1</p>
                                                <p>- Phân công và nhập điểm thi</p>
                                                <p>- Đọc dò điểm kèm mã số SV</p>
                                                <p class = "text-danger">Nội dung cập nhật phiên bản v3.0</p>
                                                <p>- Nhập điểm quá trình</p>
                                                <p  class = "text-danger">Nội dung cập nhật phiên bản v2.0.1</p>
                                                <p>- Nhập điểm có hệ số</p>
                                                <p>- Sử dụng điểm liệt cho các cột thành phần</p>
                                                <p  class = "text-danger">Nội dung cập nhật phiên bản v1.1.0</p>
                                                <p>- Thay đổi 1 số giao diện.</p>
                                                <p>- Thay đổi cấu trúc file excel xuất từ hệ thống (dùng để import). Tất cả các file excel xuất trước đó không dùng import được, GV vui lòng xuất lại file excel mới để nhập điểm và import</p>
                                                <p>- Yêu cầu mật khẩu phải có chữ, có số, có viết hoa, có viết thường, có kí hiệu đặc biệt (ví dụ @).</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-9" style = "font-size: 0.95em"> <!-- style="border-right: solid 1px #E7EAED" -->
                        @yield('content')
                    </div>

                </div>
            </div>
        </main>
    </div>

    {{-- <script src="{{ asset('js/statusbar.js') }}" defer></script> --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @yield('scripts')
</body>
</html>
