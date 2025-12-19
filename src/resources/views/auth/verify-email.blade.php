<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('/css/reset.css')  }}">
    <link rel="stylesheet" href="{{ asset('/css/user/verify.css')  }}">
</head>
<body>
    <div class="verify-email">
        <h2 class="verify-email__title">メール認証が必要です</h2>
        <p class="verify-email__message">登録したメールアドレスに送られたリンクをクリックして認証してください。</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="mail_resend--link">認証メールを再送信する</button>
        </form>
    </div>
</body>
</html>
