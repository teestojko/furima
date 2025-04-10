<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FURIMA</title>
    <link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
</head>
<body>
    <div class="verify_content">
        <h1 class="verify_title">メール受信確認</h1>
        <p class="verify_message">先のページに進む前に、メールの受信確認をしてください。</p>
        <p class="verify_message">メールを受信していない方は下記のリンクで再送信をお願いします。
            <form method="POST" class="verify_form" action="{{ route('verification.send') }}" style="display:inline;">
                @csrf
                <button class="form_retry_btn" type="submit">メールの再送信</button>
            </form>
        </p>
    </div>
    @if (session('message'))
        <div class="form_retry_message">
            {{ session('message') }}
        </div>
    @endif
</body>
</html>
