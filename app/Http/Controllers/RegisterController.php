<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:users,email',
        'password'   => 'required|confirmed|min:8',
        'profile'    => 'nullable|image|max:2048',
    ]);

    $avatarPath = null;
    if ($request->hasFile('profile')) {
    $avatarPath = $request->file('profile')->store('avatars', 'public');
}

    $user = User::create([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'password'   => Hash::make($request->password),
        'avatar'     => $avatarPath, 
        'role'       => 'USER',
    ]);

    return redirect()->route('dashboard')
    ->with('registered', true)
    ->with('success', 'Welcome, ' . $request->first_name . '! Your account has been created.');
}
}

