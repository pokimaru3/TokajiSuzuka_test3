@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/reservation_edit.css') }}">
@endsection

@section('content')
<div class="reservation-container">
    <div class="reservation-card">
        <h1 class="reservation-card_title">予約変更</h1>
        
        <form action="{{ route('reservation.update', ['id' => $reservation->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="reservation-item">
                <span class="label">予約日</span>
                <input type="date" name="reservation_date" value="{{ old('reservation_date', $reservation->reservation_date) }}">
            </div>
            <div class="reservation-item">
                <span class="label">時間</span>
                <select name="time_slot">
                    @for ($h = 11; $h <= 23; $h++)
                        @php $value = sprintf('%02d:00', $h); @endphp
                        <option value="{{ $value }}" {{ \Carbon\Carbon::parse(old('time_slot', $reservation->time_slot))->format('H:i') == $value ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="reservation-item">
                <span class="label">人数</span>
                <select name="num_of_people">
                    @foreach(range(1,50) as $num)
                        <option value="{{ $num }}" {{ old('num_of_people', $reservation->num_of_people) == $num ? 'selected' : '' }}>
                            {{ $num }}人
                        </option>
                    @endforeach
                </select>
            </div>
            <button class="edit-button" type="submit">更新する</button>
        </form>
    </div>
</div>

<script>
    const dateInput = document.querySelector('input[name="reservation_date"]');
    const timeSelect = document.querySelector('select[name="time_slot"]');
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