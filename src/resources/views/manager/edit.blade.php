@extends('layouts.manager_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/manager/edit.css') }}">
@endsection

@section('content')
<div class="detail-wrapper">
    <form action="{{ route('manager.shop.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="shop-info">
            <div class="shop-header">
                <a href="{{ route('manager.shop.index') }}" class="back-btn"><</a>
                <h2 class="shop-name">店舗情報を編集</h2>
            </div>
            <img src="{{ asset($shop->image_url) }}" class="shop-image" id="currentImage" alt="current-image">
            <img id="preview" class="shop-image" style="display:none; margin-top:10px;">
            <div class="form-group">
                <label>画像を変更する</label>
                <input type="file" name="image" id="imageInput">
                <div class="form__error">
                    @error('image')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label>店舗名</label>
                <input type="text" name="name" class="form-input" value="{{ $shop->name }}">
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label>エリア</label>
                <select name="area" class="form-input">
                    @foreach ($prefectures as $pref)
                        <option value="{{ $pref }}" {{ $shop->area === $pref ? 'selected' : '' }}>
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
                <label>ジャンル</label>
                <select name="genre" class="form-input">
                    @foreach ($genres as $genre)
                        <option value="{{ $genre }}" {{ $shop->genre === $genre ? 'selected' : '' }}>
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
                <input type="number" name="max_capacity" min="1" class="form-input" value="{{ old('max_capacity', $shop->max_capacity) }}">
                <div class="form__error">
                    @error('max_capacity')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="form-label">メールアドレス（任意）</label>
                <input type="text" name="email" class="form-input" value="{{ old('email', $shop->email) }}">
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label>説明</label>
                <textarea name="description" class="form-input">{{ $shop->description }}</textarea>
                <div class="form__error">
                    @error('description')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="btn-wrap">
                <button type="submit" class="btn">更新する</button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(event) {
        document.getElementById('currentImage').style.display = 'none';
        const preview = document.getElementById('preview');
        preview.src = event.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
});
</script>

@endsection
