<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class ManagerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('manager.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'manager';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('manager.shop.index');
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

        return redirect()->route('manager.login');
    }
}
