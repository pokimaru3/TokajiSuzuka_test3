<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Favorite;
use Carbon\Carbon;


class UserController extends Controller
{
    public function mypage()
    {
        $user = auth()->user();
        $today = Carbon::today();

        $reservations = Reservation::with('shop')
            ->where('user_id', auth()->id())
            ->whereDate('reservation_date', '>=', today())
            ->orderBy('reservation_date')
            ->orderBy('time_slot')
            ->get();

        $pastReservations = Reservation::with(['shop', 'review'])
            ->where('user_id', auth()->id())
            ->whereDate('reservation_date', '<', today())
            ->orderBy('reservation_date')
            ->get();

        $favoriteShops = Favorite::where('user_id', auth()->id())
            ->with('shop')
            ->get()
            ->pluck('shop');

        $ngrokUrl = env('NGROK_URL');

        return view('user.mypage', compact('user', 'pastReservations', 'reservations', 'favoriteShops', 'ngrokUrl'));
    }

}
