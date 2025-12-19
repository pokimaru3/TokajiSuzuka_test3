@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/detail.css') }}">
@endsection

@section('content')
<div class="detail-wrapper">
    <div class="shop-info">
        <div class="shop-header">
            <a href="/" class="back-btn"><</a>
            <h2 class="shop-name">{{ $shop->name }}</h2>
        </div>
            <img src="{{ asset($shop->image_url) }}" class="shop-image">
            <p>#{{ $shop->area }} #{{ $shop->genre }}</p>
            <p>{{ $shop->description }}</p>
            <div class="review-section">
                <h3 class="review-title">評価</h3>
                @if ($shop->reviews->isEmpty())
                    <p class="no-review">まだレビューはありません</p>
                @else
                    @foreach ($shop->reviews as $review)
                        <div class="review-card">
                            <p class="review-user">{{ $review->user->name }}</p>
                            <p class="review-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '★' : '⭐︎'}}
                                @endfor
                            </p>
                            <p class="review-comment">
                                {{ $review->comment }}
                            </p>
                        </div>
                    @endforeach
                @endif
            </div>
    </div>
    <div class="reservation-card">
        <h3 class="reservation-card_title">予約</h3>
        <form action="{{ route('reservation.store') }}" method="POST">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <input type="date" name="reservation_date" value="{{ old('reservation_date') }}">
            <div class="form__error">
                    @error('reservation_date')
                    {{ $message }}
                    @enderror
                </div>
            <select name="time_slot">
                <option value="" disabled selected>時間</option>
                @for ($h = 11; $h <= 23; $h++)
                    @php
                        $value = sprintf('%02d:00', $h);
                    @endphp
                    <option value="{{ $value }}" {{ old('time_slot') == $value ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endfor
            </select>
            <div class="form__error">
                    @error('time_slot')
                    {{ $message }}
                    @enderror
                </div>
            <select name="num_of_people">
                <option value="" disabled selected>人数</option>
                @foreach(range(1, $shop->max_capacity) as $num)
                    <option value="{{ $num }}" {{ old('num_of_people') == $num ? 'selected' : '' }}>
                        {{ $num }}人
                    </option>
                @endforeach
            </select>
            <div class="form__error">
                @error('num_of_people')
                {{ $message }}
                @enderror
            </div>
            <div class="summary-box">
                <p class="reservation-item">
                    <span class="label">Shop</span>
                    <span class="value">{{ $shop->name }}</span>
                </p>
                <p class="reservation-item">
                    <span class="label">Date</span>
                    <span class="value" id="summary-date" id="summary-date"></span>
                </p>
                <p class="reservation-item">
                    <span class="label">Time</span>
                    <span class="value" id="summary-time"></span>
                </p>
                <p class="reservation-item">
                    <span class="label">Number</span>
                    <span class="value" id="summary-num"></span>
                </p>
            </div>
            <button type="submit">予約する</button>
        </form>
    </div>
</div>

<script>
    const dateInput = document.querySelector('input[name="reservation_date"]');
    const timeSelect = document.querySelector('select[name="time_slot"]');
    const numSelect = document.querySelector('select[name="num_of_people"]');
    const summaryDate = document.getElementById('summary-date');
    const summaryTime = document.getElementById('summary-time');
    const summaryNum = document.getElementById('summary-num');
    const oldDate = @json(old('reservation_date'));
    const oldTime = @json(old('time_slot'));
    const oldNum  = @json(old('num_of_people'));
    if (oldDate) {
        summaryDate.textContent = oldDate;
    }
    if (oldTime) {
        summaryTime.textContent = oldTime;
    }
    if (oldNum) {
        summaryNum.textContent = oldNum + "人";
    }
    dateInput.addEventListener('change', function () {
        summaryDate.textContent = this.value;
    });
    timeSelect.addEventListener('change', function () {
        summaryTime.textContent = this.value;
    });
    numSelect.addEventListener('change', function () {
        summaryNum.textContent = this.value + "人";
    });

    dateInput.setAttribute("min", new Date().toISOString().split("T")[0]);
    function controlTimeOptions() {
        const selectedDate = dateInput.value;
        const today = new Date();
        const ymd = today.toISOString().split("T")[0];
        for (const option of timeSelect.options) {
            option.disabled = false;
        }
        if (selectedDate === ymd) {
            for (const option of timeSelect.options) {
                const timeValue = option.value;
                if (!timeValue) continue;
                const [h, m] = timeValue.split(":").map(Number);
                const optionTime = new Date(today.getFullYear(), today.getMonth(), today.getDate(), h, m);
                if (optionTime <= today) {
                    option.disabled = true;
                }
            }
        }
    }
    dateInput.addEventListener("change", controlTimeOptions);
    window.addEventListener("DOMContentLoaded", controlTimeOptions);
</script>

@endsection