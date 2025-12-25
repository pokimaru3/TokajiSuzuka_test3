@extends('layouts.admin_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/create.css') }}">
@endsection

@section('content')
<div class="admin-create-wrapper">
    <h2 class="admin-create-title">店舗代表者を作成</h2>
    <form action="{{ route('admin.store') }}" method="POST" class="admin-create-form">
        @csrf
        <div class="form-group">
            <label for="name" class="form-label">名前</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-input">
            <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="form-label">メールアドレス</label>
            <input id="email" type="text" name="email" value="{{ old('email') }}" class="form-input">
            <div class="form__error">
                @error('email')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="form-label">パスワード</label>
            <input id="password" type="password" name="password" class="form-input">
            <div class="form__error">
                @error('password')
                {{ $message }}
                @enderror
            </div>
        </div>
        <button type="submit" class="btn">作成</button>
    </form>
</div>
@endsection