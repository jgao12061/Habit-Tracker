<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // ← add this

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'username' => 'nullable|string|max:255',
            'gender'   => 'nullable|string',
            'bio'      => 'nullable|string|max:500',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'avatar'   => 'nullable|image|max:3072',
        ]);

        $nameParts = explode(' ', $request->name, 2);
            $user->first_name = $nameParts[0];
            $user->last_name  = $nameParts[1] ?? '';
            $user->email    = $request->email;
            $user->username = $request->username;
            $user->gender   = $request->gender;
            $user->bio      = $request->bio;
            $user->phone    = $request->phone;
            $user->address  = $request->address;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::delete('public/' . $user->avatar);
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();


        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }
}