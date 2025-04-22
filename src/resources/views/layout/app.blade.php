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
        <link rel="stylesheet" href="{{ mix('css/Sidebar.css') }}">

        @yield('css')
    </head>
    <body>
        <header class="header_main">
            <div class="header__inner">
                <div class="header-utilities">
                    <div class="header__logo">
                        FURIMA
                    </div>
                </div>
            </div>
        </header>

        <div id="sidebar"></div>

        <main>
            @yield('content')
        </main>

        <div id="app"></div>

        <script>
            window.Laravel = {
                isLoggedIn: {{ Auth::check() ? 'true' : 'false' }}
            };
        </script>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
