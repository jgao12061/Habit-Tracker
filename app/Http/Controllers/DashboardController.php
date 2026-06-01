<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Habit;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Totals
        $totalUsers    = User::count();
        $totalHabits   = Habit::count();
        $activeStreaks = Habit::sum('streak');
        $totalCategories = 6; // fixed number since categories are hardcoded strings

        $startOfWeek = Carbon::now()->startOfWeek();
        $registrations = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i);
            $registrations[] = User::whereDate('created_at', $day)->count();
            }

        // Habits by Category 
        $habitsByCategory = [
            Habit::where('category', 'Health')->count(),
            Habit::where('category', 'Study')->count(),
            Habit::where('category', 'Fitness')->count(),
            Habit::where('category', 'Mindfulness')->count(),
            Habit::where('category', 'Creative')->count(),
            Habit::where('category', 'Social')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalHabits',
            'activeStreaks',
            'totalCategories',
            'registrations',
            'habitsByCategory'
        ));
    }
}