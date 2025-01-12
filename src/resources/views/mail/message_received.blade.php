<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h3>新しいメッセージを受信しました</h3>
    <p>送信者: {{ $senderName }}</p>
    <p class="user_notification">
        {{ $messageContent }}
    </p>
</body>
</html>
