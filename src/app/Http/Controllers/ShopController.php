<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Favorite;


class ShopController extends Controller
{
    public function index()
    {
        if (session()->has('search_ids')) {
            $shopIds = session('search_ids');
            $shops = Shop::whereIn('id', $shopIds)->get();
        } else {
            $shops = Shop::all();
        }

        $prefectures = config('shop.prefectures');
        $genres = config('shop.genres');

        return view('user.index', compact('shops', 'prefectures', 'genres'));
    }

    public function search(Request $request)
    {
        $query = Shop::query();

        if ($request->area) {
            $query->where('area', $request->area);
        }
        if ($request->genre) {
            $query->where('genre', $request->genre);
        }
        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $shops = $query->get();
        $shopIds = $shops->pluck('id')->toArray();

        return redirect()->route('user.index')->with([
            'search_ids' => $shopIds,
            'search_area' => $request->area,
            'search_genre' => $request->genre,
            'search_keyword' => $request->keyword,
        ]);
    }

    public function toggle(Request $request)
    {
        $user = auth()->user();
        $shopId = $request->shop_id;

        $favorite = Favorite::where('user_id', $user->id)
            ->where('shop_id', $shopId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['favorited' => false]);
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'shop_id' => $shopId
            ]);
            return response()->json(['favorited' => true]);
        }
    }

    public function show($shop_id)
    {
        $shop = Shop::findOrFail($shop_id);

        return view('user.detail', compact('shop'));
    }
}
