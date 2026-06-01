<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    //Form Sub
    public function store(Request $request) 
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|string',
            'profile' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('profiles', 'public');
        }

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'profile' => $path,
        ]);

        return redirect()->route('users.index')->with('success','User created successfully!');
    }

    //Edit Form
    public function edit(User $user)
    {
        $users = User::all();
        return view('admin.users', compact('users', 'user'));
    }

    //Update
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|string',
            'profile' => 'nullable|image|max:2048',
        ]);

        $path = $user->profile;
        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('profiles', 'public');
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'profile' => $path,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    //Delete User
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}







