<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FURIMA</title>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <div class="login_content">
    <div class="login_detail">
        <div class="login_form">
            <div class="login_form_heading">
                <div class="login_title">
                    Login
                </div>
            </div>
            <form class="form" action="{{ route('login') }}" method="post">
                @csrf
                    <div class="form_group_content">
                        <div class="form_input_text">
                            <i class="fas fa-envelope fa-xl" ></i>
                            <input class="email_input" type="email" name="email" value="{{ old('email') }}" placeholder="Email"/>
                        </div>
                    </div>
                    <div class="form_group_content2">
                        <div class="form_input_text">
                            <i class="fa-solid fa-lock fa-xl"></i>
                            <input class="password_input" type="password" name="password" placeholder="Password"/>
                        </div>
                    </div>
                <div class="form_button">
                    <button class="form_button_submit" type="submit">
                        ログイン
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="form_error">
        @error('email')
            {{ $message }}
        @enderror
    </div>
    <div class="form_error">
        @error('password')
            {{ $message }}
        @enderror
    </div>
    <div class="login_buttons">
        <a href="{{ route('admin.login') }}" class="login_button admin_button">
            管理者ログイン
        </a>
    </div>
    <div class="login_buttons">
        <a class="login_button register_button" href="/register">
            会員登録
        </a>
    </div>
</div>
</body>
</html>
