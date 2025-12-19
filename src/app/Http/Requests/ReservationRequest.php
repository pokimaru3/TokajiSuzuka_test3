<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'reservation_date' => [
                'required',
                'date',
            ],
            'time_slot' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = Reservation::where('user_id', auth()->id())
                        ->where('shop_id', $this->input('shop_id'))
                        ->where('reservation_date', $this->input('reservation_date'))
                        ->where('time_slot', $value)
                        ->exists();
                    if ($exists) {
                        $fail('この日時ですでに予約済みです。');
                    }
                },
            ],
            'num_of_people' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'reservation_date.required' => '予約日を選択してください。',
            'time_slot.required' => '時間を選択してください。',
            'num_of_people.required' => '人数を選択してください。',
        ];
    }
}
