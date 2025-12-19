@extends('layouts.manager_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__content">
    <div class="login-card">
        <div class="title">Manager Login</div>
        <form class="form" action="/manager/login" method="post">
            @csrf
            <div class="form-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="text" name="email" placeholder="Email" value="{{ old('email') }}">
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <img src="{{ asset('images/lock.jpeg') }}" alt="lock" class="lock-icon">
                <input type="password" name="password" placeholder="Password">
                <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__button">
                <button class="form__button--submit">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection