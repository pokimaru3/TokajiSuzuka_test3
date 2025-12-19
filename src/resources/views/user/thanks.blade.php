@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/thanks.css') }}">
@endsection


@section('content')
<div class="thanks__content">
    <div class="thanks-card">
        <div class="thanks__title">会員登録ありがとうございます</div>
        <a href="/" class="btn">ログインする</a>
    </div>
</div>
@endsection