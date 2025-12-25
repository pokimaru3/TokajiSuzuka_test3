@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/register.css') }}">
@endsection

@section('content')
<div class="register__content">
    <div class="register-card">
        <div class="title">Registration</div>
        <form class="form" action="/register" method="post">
            @csrf
            <div class="form-group">
                <img src="{{ asset('images/man.jpeg') }}" alt="man" class="man-icon">
                <input type="text" name="name" placeholder="Username" value="{{ old('name') }}">
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
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
                <button class="form__button--submit">登録</button>
            </div>
        </form>
    </div>
</div>

@endsection

