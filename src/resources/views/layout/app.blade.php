<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>FURIMA</title>
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layout/common.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        @yield('css')
    </head>
    <body>
        <header class="header_main">
            <div class="header__inner">
                <div class="header-utilities">
                    <div class="hamburger">
                        <div class="hamburger-menu">
                            <div class="line1"></div>
                            <div class="line2"></div>
                            <div class="line3"></div>
                        </div>
                    </div>
                    <div class="header__logo">
                        FURIMA
                    </div>
                </div>
                <nav class="nav" id="nav">
                    <ul class="nav_ul">
                        @if(Auth::check())
                            <li class="nav_list">
                                <a class="nav_a" href="/">
                                    Home
                                </a>
                            </li>
                            <li class="nav_list">
                                <form class="form" action="/logout" method="post">
                                @csrf
                                    <button type="submit" class="nav_button">
                                        Logout
                                    </button>
                                </form>
                            </li>
                            <li class="nav_list">
                                <a class="nav_a" href="/my_page/{shop}">
                                    MyPage
                                </a>
                            </li>
                        @else
                            <li class="nav_list">
                                <a class="nav_a" href="/home">
                                    Home
                                </a>
                            </li>
                            <li class="nav_list">
                                <a class="nav_a" href="/register">
                                    Registration
                                </a>
                            </li>
                            <li class="nav_list">
                                <a class="nav_a" href="/login">
                                    Login
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            @yield('content')
        </main>
        <script>
            document.querySelector('.hamburger').addEventListener('click', function () {
                var nav = document.getElementById('nav');
                var logo = document.querySelector('.header__logo');
                var hamburgerMenu = document.querySelector('.hamburger-menu');
                nav.classList.toggle('active');
                document.querySelector('main').classList.toggle('dimmed');
                logo.classList.toggle('hidden');
                hamburgerMenu.classList.toggle('open');
            });
        </script>
        @yield('scripts')
</body>

</html>
