<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rese</title>
</head>
<body>
    <h2>予約QRコード</h2>
    {!! QrCode::size(250)->generate($qrUrl) !!}
</body>
</html>