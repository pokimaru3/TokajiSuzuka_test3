<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;


class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt(array_merge($credentials, ['role' => 'admin']))) {
            $request->session()->regenerate();
            return redirect()->route('admin.index');
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
