<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('meta')
    {{-- bootstrap css --}}
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" />
    {{-- fontawsome --}}
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}" />
    {{-- custum css --}}
    @yield('css')
    <title>@yield('title')</title>
</head>

<body class="container-fluid p-0">
    @auth
    <x-navbar />
    <x-sidebar />
    @endauth
    @guest
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                        @if (Route::has('policy'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('policy') }}">{{ __('Privacy Policy') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('editprofile') }}">
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('changepassword') }}">
                                    {{ __('Change Password') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @endguest
    @yield('content')
    {{-- jquery --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    {{-- bootstrap js--}}
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @yield('js')
    <script>
        $(document).ready(function () {
            $('#sidebar_btn').click(function () {
                $('#sidebar').toggleClass('active');
                $('#register .form').toggleClass("active");
            });
            $('.dropdown-btn').click(function () {
                const target = $(event.currentTarget).find('i');
                if ($(target[1]).hasClass("fa-chevron-left")) {
                    $(target[1]).removeClass('fa-chevron-left');
                    $(target[1]).addClass('fa-chevron-down');
                    $(event.currentTarget).addClass('d-active');
                } else {
                    $(target[1]).removeClass('fa-chevron-down');
                    $(target[1]).addClass('fa-chevron-left');
                    $(event.currentTarget).removeClass('d-active');
                }
            })
        });

    </script>
</body>

</html>
