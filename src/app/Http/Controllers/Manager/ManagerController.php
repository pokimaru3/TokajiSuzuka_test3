<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagerShopRequest;
use App\Http\Requests\ManagerMailRequest;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\HttpCache\Store;
use App\Mail\ShopNoticeMail;
use Illuminate\Support\Facades\Mail;

class ManagerController extends Controller
{
    public function create()
    {
        $prefectures = config('shop.prefectures');
        $genres = config('shop.genres');

        return view('manager.create', compact('prefectures', 'genres'));
    }

    public function store(ManagerShopRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $imageUrl = 'storage/' . $path;
        } else {
            $imageUrl = 'images/no-image.png';
        }

        $managerId = Auth::id();

        Shop::create([
            'manager_id' => $managerId,
            'name' => $validated['name'],
            'area' => $validated['area'],
            'genre' => $validated['genre'],
            'max_capacity' => $validated['max_capacity'],
            'description' => $validated['description'],
            'email' => $validated['email'] ?? null,
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('manager.shop.index');
    }

    public function index()
    {
        $managerId = Auth::id();

        $shops = Shop::where('manager_id', $managerId)->get();

        return view('manager.index', compact('shops'));
    }

    public function edit(Shop $shop)
    {
        if ($shop->manager_id !== Auth::id()) {
            abort(403);
        }

        $prefectures = config('shop.prefectures');
        $genres = config('shop.genres');

        return view('manager.edit', compact('shop', 'prefectures', 'genres'));
    }

    public function update(ManagerShopRequest $request, Shop $shop)
    {
        if ($shop->manager_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $shop->image_url = 'storage/' . $path;
        }

        $data = [
            'name' => $validated['name'],
            'area' => $validated['area'],
            'genre' => $validated['genre'],
            'max_capacity' => $validated['max_capacity'],
            'description' => $validated['description'],
        ];

        if (array_key_exists('email', $validated)) {
            $data['email'] = $validated['email'];
        }

        $shop->update($data);

        return redirect()->route('manager.shop.index');
    }

    public function showMailForm(Shop $shop)
    {
        if ($shop->manager_id !== auth()->id()) {
            abort(403);
        }

        $users = User::whereHas('reservations', function ($q) use ($shop){
            $q->where('shop_id', $shop->id);
        })->get();

        return view('manager.mail', compact('shop', 'users'));
    }

    public function send(ManagerMailRequest $request, Shop $shop)
    {
        if ($shop->manager_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validated();

        $user = User::where('id', $request->user_id)
            ->whereHas('reservations', function ($q) use ($shop) {
                $q->where('shop_id', $shop->id);
            })
            ->firstOrFail();

        Mail::to($user->email)
            ->send(new ShopNoticeMail(
                $shop,
                $request->subject,
                $request->body
            ));

        return redirect()->route('manager.shop.index');
    }

}
