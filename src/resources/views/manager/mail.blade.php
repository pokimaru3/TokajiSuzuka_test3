@extends('layouts.manager_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/manager/mail.css') }}">
@endsection

@section('content')
<div class="mail-send-wrapper">
    <h2 class="mail-send__title">お知らせメール送信</h2>
    <form action="{{ route('manager.mail.send', $shop->id) }}" method="post">
        @csrf
        <label class="label">送信先ユーザー</label>
        <select name="user_id" class="form-input">
            <option value="">選択してください</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}（{{ $user->email }}）
                </option>
            @endforeach
        </select>
        <div class="form__error">
            @error('user_id'){{ $message }}@enderror
        </div>
        <label class="label">件名</label>
        <input type="text" name="subject" class="form-input" value="{{ old('subject') }}">
        <div class="form__error">
            @error('subject'){{ $message }}@enderror
        </div>
        <label class="label">本文</label>
        <textarea name="body" class="form-input">{{ old('body') }}</textarea>
        <div class="form__error">
            @error('body'){{ $message }}@enderror
        </div>
        <button type="submit" class="btn">送信</button>
    </form>
</div>
@endsection