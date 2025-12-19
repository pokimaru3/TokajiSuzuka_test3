<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rese</title>
</head>
<body>
    <h2>予約内容</h2>
    @if(isset($message))
        <p>{{ $message }}</p>
    @else
        <p>予約ID：{{ $reservation->id }}</p>
        <p>ユーザー：{{ $reservation->user->name }}さん</p>
        <p>店舗：{{ $reservation->shop->name }}</p>
        <p>日付：{{ $reservation->reservation_date }}</p>
        <p>時間：{{ \Carbon\Carbon::parse($reservation->time_slot)->format('H:i') }}</p>
        <p>人数：{{ $reservation->num_of_people }}人</p>
        @if($isToday)
            <p style="color: green; font-weight: bold;">✔ 本日の予約です</p>
        @else
            <p style="color: red; font-weight: bold;">※ 本日の予約ではありません</p>
        @endif
    @endif
</body>
</html>