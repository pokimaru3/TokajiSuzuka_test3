<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function store(ReservationRequest $request)
    {
        Reservation::create([
            'user_id' => auth()->id(),
            'shop_id' => $request->shop_id,
            'reservation_date' => $request->reservation_date,
            'time_slot' => $request->time_slot,
            'num_of_people' => $request->num_of_people,
        ]);

        return redirect()->route('reservation.complete');
    }

    public function complete()
    {
        return view('user.complete');
    }

    public function cancel(Request $request)
    {
        $reservation = Reservation::where('id', $request->reservation_id)
            ->where('user_id', Auth::id())
            ->first();

        $reservation->delete();

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('user.reservation_edit', compact('reservation'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }
        $reservation->update([
            'reservation_date' => $request->reservation_date,
            'time_slot' => $request->time_slot,
            'num_of_people' => $request->num_of_people,
        ]);

        return redirect()->route('mypage');
    }

    public function verify($id)
    {
        $reservation = Reservation::with(['user', 'shop'])->find($id);

        if (!$reservation) {
            return view('manager.reservation', ['message' => '予約が見つかりません。']);
        }

        $isToday = $reservation->reservation_date === today()->toDateString();

        return view('manager.reservation', [
            'reservation' => $reservation,
            'isToday' => $isToday
        ]);
    }

    public function isVisited(Reservation $reservation)
    {
        return Carbon::parse($reservation->reservation_date)->isPast();
    }

    public function showQr($id)
    {
        $reservation = Reservation::findOrFail($id);

        $ngrokUrl = env('NGROK_URL');

        $qrUrl = $ngrokUrl . '/reservation/' . $reservation->id . '/verify';

        return view('user.qr', compact('reservation', 'qrUrl'));
    }
}
