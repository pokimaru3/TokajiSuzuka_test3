@extends('layouts.manager_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/manager/create.css') }}">
@endsection

@section('content')
<div class="shop-create-wrapper">
    <h2 class="shop-create-title">店舗を作成</h2>
    <form action="{{ route('manager.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name" class="form-label">店舗名</label>
            <input type="text" name="name" class="form-input" value="{{ old('name') }}">
            <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="area" class="form-label">エリア</label>
            <select name="area">
                <option value="" disabled selected>選択してください</option>
                @foreach ($prefectures as $pref)
                    <option value="{{ $pref }}" {{ old('area') == $pref ? 'selected' : '' }}>
                        {{ $pref }}
                    </option>
                @endforeach
            </select>
            <div class="form__error">
                @error('area')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="genre" class="form-label">ジャンル</label>
            <select name="genre">
                <option value="" disabled selected>選択してください</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre }}" {{ old('genre') == $genre ? 'selected' : ''}}>
                        {{ $genre }}
                    </option>
                @endforeach
            </select>
            <div class="form__error">
                @error('genre')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="max_capacity" class="form-label">最大予約可能人数</label>
            <input type="number" name="max_capacity" min="1" class="form-input" value="{{ old('max_capacity') }}">
            <div class="form__error">
                @error('max_capacity')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="form-label">メールアドレス（任意）</label>
            <input type="text" name="email" class="form-input" value="{{ old('email') }}">
            <div class="form__error">
                @error('email')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="form-label">店舗説明</label>
            <textarea name="description" class="form-input">{{ old('description') }}</textarea>
            <div class="form__error">
                @error('description')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="image" class="form-label">店舗画像</label>
            <input type="file" name="image" id="imageInput">
            <img id="preview" style="max-width: 200px; margin-top: 10px; display:none;">
            <div class="form__error">
                @error('image')
                {{ $message }}
                @enderror
            </div>
        </div>
        <button type="submit" class="btn">登録する</button>
    </form>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(event) {
        const preview = document.getElementById('preview');
        preview.src = event.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
});
</script>

@endsection