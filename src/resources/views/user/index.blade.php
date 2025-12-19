@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/index.css') }}">
@endsection


@section('content')
@php
    $selectedArea = session('search_area') ?? request('area') ?? '';
    $selectedGenre = session('search_genre') ?? request('genre') ?? '';
    $selectedKeyword = session('search_keyword') ?? request('keyword') ?? '';
@endphp
<form action="{{ route('shops.search') }}" method="POST" class="search-box">
    @csrf
    <select name="area">
        <option value="" {{ $selectedArea == '' ? 'selected' : '' }}>
            All area
        </option>
        @foreach($prefectures as $prefecture)
            <option value="{{ $prefecture }}"
                {{ $selectedArea == $prefecture ? 'selected' : '' }}>
                {{ $prefecture }}
            </option>
        @endforeach
    </select>
    <select name="genre">
        <option value="">All genre</option>
        @foreach ($genres as $genre)
            <option value="{{ $genre }}" {{ $selectedGenre == $genre ? 'selected' : '' }}>
            {{ $genre }}
        </option>
        @endforeach
    </select>
    <div class="search-input">
        <span class="material-symbols-outlined search-icon">search</span>
        <input type="text" name="keyword" placeholder="Search ..." value="{{ $selectedKeyword }}">
    </div>
</form>
@if(session()->has('search_ids'))
    <p class="search-result-count">検索結果: {{ count(session('search_ids')) }} 件</p>
@endif
<div class="shop-list-container">
    @foreach ($shops as $shop)
        <div class="shop-card">
            <img src="{{ asset($shop->image_url) }}" alt="{{ $shop->name }}" class="shop-card__image">
            <div class="shop-card__body">
                <h3 class="shop-card__title">{{ $shop->name }}</h3>
                <p class="shop-card__tags">
                    #{{ $shop->area }}
                    #{{ $shop->genre }}
                </p>
                <a href="{{ route('user.detail', ['shop_id' => $shop->id]) }}" class="btn-detail">
                    詳しくみる
                </a>
                <div class="favorite-btn">
                    @auth
                        <button class="favorite-icon {{ $shop->isFavoritedBy(auth()->user()) ? 'active' : '' }}" data-shop-id="{{ $shop->id }}">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    @else
                        <a href="/login" class="guest">
                            <i class="fa-solid fa-heart"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.search-box');

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            form.submit();
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".favorite-icon").forEach(button => {
        button.addEventListener("click", async function () {
            const shopId = this.dataset.shopId;

            const response = await fetch("{{ route('favorite.toggle') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ shop_id: shopId })
            });

            const data = await response.json();
            const icon = this.querySelector("i");

            if (data.favorited) {
                icon.classList.add("active");
                icon.classList.remove("inactive");
                this.classList.add("active");
            } else {
                icon.classList.remove("active");
                icon.classList.add("inactive");
                this.classList.remove("active");
            }
        });
    });
});
</script>

@endsection