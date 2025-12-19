<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function create(Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reservation->review) {
            return redirect()->back()->with('error', 'この予約はすでにレビュー済みです');
        }

        return view('user.review', compact('reservation'));
    }

    public function store(ReviewRequest $request, Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        Review::create([
            'user_id' => auth()->id(),
            'shop_id' => $reservation->shop_id,
            'reservation_id' => $reservation->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('mypage');
    }
}
