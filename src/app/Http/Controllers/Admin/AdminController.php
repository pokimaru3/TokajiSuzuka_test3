<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminManagerStoreRequest;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function create()
    {
        return view('admin.create');
    }

    public function store(AdminManagerStoreRequest $request)
    {
        $validated = $request->validated();
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'manager',
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function index()
    {
        $managers = User::where('role', 'manager')->get();

        return view('admin.index', compact('managers'));
    }
}
