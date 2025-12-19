@extends('layouts.manager_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/manager/index.css') }}">
@endsection

@section('content')
<div class="manager-shops-wrapper">
    <h2 class="manager-shops-title">登録店舗一覧</h2>
    @if ($shops->isEmpty())
        <p class="message">- 登録店舗がありません -</p>
    @else
    <table class="manager-shops-table">
        <thead class="manager-shops__header">
            <tr>
                <th>店舗名</th>
                <th>エリア</th>
                <th>ジャンル</th>
                <th>メールアドレス</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shops as $shop)
                <tr>
                    <td>{{ $shop->name }}</td>
                    <td>{{ $shop->area }}</td>
                    <td>{{ $shop->genre }}</td>
                    <td>{{ $shop->email }}</td>
                    <td>
                        <a href="{{ route('manager.shop.edit', $shop->id) }}" class="edit-btn">
                            編集
                        </a>
                        @if ($shop->email)
                            <a href="{{ route('manager.mail.create', $shop->id) }}" class="send-btn">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                        @else
                            <span class="send-btn send-btn--disabled" title="メールアドレス未設定">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection