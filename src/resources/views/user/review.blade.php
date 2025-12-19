@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/review.css') }}">
@endsection

@section('content')
<div class="review-wrapper">
    <h2 class="review__title">{{ $reservation->shop->name }}の評価</h2>
    <form method="POST" action="{{ route('reviews.store', $reservation->id) }}">
        @csrf
        <label class="label">5段階評価</label>
        <div class="star-rating">
            @for ($i = 1; $i <= 5; $i++)
                <span class="star {{ old('rating') >= $i ? 'active' : '' }}" data-value="{{ $i }}">★</span>
            @endfor
        </div>
        <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}">
        @error('rating')
            <p class="form__error">{{ $message }}</p>
        @enderror
        <label class="label">コメント</label>
        <textarea name="comment" class="review__comment">{{ old('comment') }}</textarea>
        @error('comment')
            <p class="form__error">{{ $message }}</p>
        @enderror
        <button type="submit" class="btn">送信</button>
    </form>
</div>

<script>
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');
    stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = star.dataset.value;
            ratingInput.value = value;
            stars.forEach(s => {
                s.classList.toggle('active', s.dataset.value <= value);
            });
        });
    });
</script>
@endsection