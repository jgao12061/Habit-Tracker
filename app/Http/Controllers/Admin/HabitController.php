<?php

namespace App\Http\Controllers\Admin;
use App\Models\Habit;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class HabitController extends Controller
{
   
    public function index() {
  $habits = Habit::with('user')->get();
  $users  = User::all();
  $categoryColors = [
    'Health'      => '#4ade80',
    'Study'       => '#60a5fa',
    'Fitness'     => '#f97316',
    'Mindfulness' => '#c084fc',
    'Creative'    => '#fb7185',
    'Social'      => '#fbbf24',
  ];

  return view('admin.habits', compact('habits', 'users', 'categoryColors'));
}
    public function create()
{
    $users = User::all();
    return view('habits.create', compact('users'));
}

public function edit(Habit $habit)
{
    $users = User::all();
    return view('habits.edit', compact('habit', 'users'));
}

public function store(Request $request)
{
    $request->validate([
        'title'    => 'required|string|max:255',
        'category' => 'required|string',
        'user_id'  => 'required|exists:users,id',
    ]);

    Habit::create([
        'title'    => $request->title,
        'category' => $request->category,
        'user_id'  => $request->user_id,
        'streak'   => 0,
        'is_active'=> true,
    ]);

    return redirect()->route('habits.index')->with('success', 'Habit added successfully!');
}

public function update(Request $request, Habit $habit)
{
    $request->validate([
        'title'    => 'required|string|max:255',
        'category' => 'required|string',
        'user_id'  => 'required|exists:users,id',
    ]);

    $habit->update([
        'title'    => $request->title,
        'category' => $request->category,
        'user_id'  => $request->user_id,
    ]);

    return redirect()->route('habits.index')->with('success', 'Habit updated successfully!');
}

public function destroy(Habit $habit)
{
    $habit->delete();
    return redirect()->route('habits.index')->with('success', 'Habit deleted successfully!');
}

public function toggle(Habit $habit)
{
    $isNowDone = $habit->is_active;

    $habit->update([
        'is_active' => !$habit->is_active,
        'streak'    => $isNowDone ? $habit->streak + 1 : max(0, $habit->streak - 1),
    ]);

    return response()->json([
        'is_active' => $habit->is_active,
        'streak'    => $habit->streak,
    ]);
}

}
