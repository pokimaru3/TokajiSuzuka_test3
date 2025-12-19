@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/mypage.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
@endsection

@section('content')
<div class="mypage-wrapper">
    <div class="reservation-column">
        <div class="reservation-container">
            <h2 class="reservation__title">予約状況</h2>
            @foreach ($reservations->sortBy(['reservation_date', 'time_slot']) as $index => $reservation)
            <div class="reservation-card" id="reservation-{{ $reservation->id }}">
                <div class="reservation-header">
                    <img src="{{ asset('images/clock.jpeg') }}" alt="clock" class="clock-icon">
                    <div class="reservation-card__title">予約{{ $index + 1 }}</div>
                </div>
                <a href="{{ route('reservation.edit', ['id' => $reservation->id]) }}" class="edit-btn">
                    予約変更
                </a>
                <button class="cancel-btn" data-reservation-id="{{ $reservation->id }}" title="キャンセル">
                    <span class="material-symbols-outlined">cancel</span>
                </button>
                <p class="reservation-item">
                    <span class="label">Shop</span>
                    <span class="value">{{ $reservation->shop->name }}</span>
                </p>
                <p class="reservation-item">
                    <span class="label">Date</span>
                    <span class="value">{{ $reservation->reservation_date }}</span>
                </p>
                <p class="reservation-item">
                    <span class="label">Time</span>
                    <span class="value">{{ \Carbon\Carbon::parse($reservation->time_slot)->format('H:i') }}</span>
                </p>
                <p class="reservation-item">
                    <span class="label">Number</span>
                    <span class="value">{{ $reservation->num_of_people }}人</span>
                </p>
                <a href="{{ route('reservation.qr', ['id' => $reservation->id]) }}" class="qr-link">
                    QRコードを表示
                </a>
            </div>
            @endforeach
        </div>
        <div class="reservation-container">
            @if ($pastReservations->isNotEmpty())
                <h2 class="reservation__title">来店履歴</h2>
                @foreach ($pastReservations as $reservation)
                    <div class="reservation-card">
                        <p class="reservation-item">
                            <span class="label">Shop</span>
                            <span class="value">{{ $reservation->shop->name }}</span>
                        </p>
                        <p class="reservation-item">
                            <span class="label">Date</span>
                            <span class="value">{{ $reservation->reservation_date }}</span>
                        </p>
                        @if (!$reservation->review)
                            <a href="{{ route('reviews.create', $reservation->id) }}" class="review-link">
                                評価する
                            </a>
                        @else
                            <p class="review-status">★レビュー済み</p>
                        @endif
                    </div>
                @endforeach
            @else
                <h2 class="reservation__title">来店履歴</h2>
                <p class="empty-message">まだ来店履歴はありません</p>
            @endif
        </div>
    </div>
    <div class="favorite-container">
        <p class="user-name">{{ auth()->user()->name }}さん</p>
        <h2 class="favorite__title">お気に入り店舗</h2>
        <div class="favorite-list">
            @foreach ($favoriteShops as $shop)
            <div class="shop-card">
                <img src="{{ asset($shop->image_url) }}" class="shop-card__image">
                <div class="shop-card__body">
                    <h3>{{ $shop->name }}</h3>
                    <p>#{{ $shop->area }} #{{ $shop->genre }}</p>
                    <a href="{{ route('user.detail', ['shop_id' => $shop->id]) }}" class="btn-detail">詳しくみる</a>
                    <div class="favorite-btn">
                        <button class="favorite-icon active" data-shop-id="{{ $shop->id }}">
                            <span class="material-icons">favorite</span>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
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
            const icon = this.querySelector(".material-icons");
            if (data.favorited) {
                this.classList.add("active");
                icon.textContent = "favorite";
            } else {
                this.classList.remove("active");
                icon.textContent = "favorite_border";
                this.closest(".shop-card").remove();
            }
        });
    });

    document.querySelectorAll(".cancel-btn").forEach(button => {
        button.addEventListener("click", async function () {
            const reservationId = this.dataset.reservationId;
            const response = await fetch("{{ route('reservation.cancel') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ reservation_id: reservationId })
            });
            const data = await response.json();
            if (data.success) {
                const card = document.getElementById(`reservation-${reservationId}`);
                if (card) card.remove();
            }
        });
    });
});
</script>
@endsection
