@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/complete.css') }}">
@endsection

@section('content')
<div class="thanks__content">
    <div class="thanks-card">
        <div class="thanks__title">ご予約ありがとうございます</div>
        <a href="/" class="btn">戻る</a>
    </div>
</div>
@endsection